<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SecureFileUpload
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limiting for file uploads
        $key = 'file-upload:' . $request->ip();
        $maxAttempts = config('filesystems.upload_rate_limit', 10); // 10 uploads per minute
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'success' => false,
                'message' => 'Too many upload attempts. Try again in ' . $seconds . ' seconds.',
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        // Check if uploads are enabled
        if (!config('filesystems.uploads_enabled', true)) {
            return response()->json([
                'success' => false,
                'message' => 'File uploads are currently disabled'
            ], 503);
        }

        // Validate request origin (CSRF protection is already handled by Laravel)
        if (!$this->isValidOrigin($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request origin'
            ], 403);
        }

        // Check disk space
        if (!$this->hasSufficientDiskSpace()) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient disk space for upload'
            ], 507);
        }

        // Check file security if file is present
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!$this->isSecureFile($file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Potentially dangerous file detected'
                ], 422);
            }
        }

        // Add security headers to response
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
    }

    /**
     * Check if the uploaded file is secure
     */
    private function isSecureFile($file): bool
    {
        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        $dangerousExtensions = [
            'php', 'phtml', 'php3', 'php4', 'php5', 'phar',
            'js', 'vbs', 'bat', 'cmd', 'com', 'exe', 'scr',
            'msi', 'msp', 'hta', 'cpl', 'msc', 'jar'
        ];

        if (in_array($extension, $dangerousExtensions)) {
            return false;
        }

        // Check file headers
        $handle = fopen($file->getPathname(), 'r');
        if (!$handle) {
            return false;
        }

        $header = fread($handle, 2048); // Read more bytes for thorough check
        fclose($handle);

        // Look for suspicious patterns
        $dangerousPatterns = [
            '<?php', '<?=', '<%', '<script', 'javascript:', 'vbscript:',
            'eval(', 'base64_decode', 'exec(', 'system(', 'shell_exec(',
            'passthru(', 'file_get_contents(', '__halt_compiler',
            'from:', 'import', 'require(', 'include(',
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (stripos($header, $pattern) !== false) {
                return false;
            }
        }

        // Check for double extensions (e.g., file.jpg.php)
        $filename = $file->getClientOriginalName();
        $parts = explode('.', $filename);
        if (count($parts) > 2) {
            // Check if any part before the last extension is dangerous
            for ($i = 1; $i < count($parts) - 1; $i++) {
                if (in_array(strtolower($parts[$i]), $dangerousExtensions)) {
                    return false;
                }
            }
        }

        // Additional MIME type validation
        $mimeType = $file->getMimeType();
        $allowedMimes = config('filesystems.allowed_mime_types', [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
            'video/mp4', 'video/webm', 'video/ogg', 'video/avi', 'video/quicktime',
            'application/pdf', 'text/plain',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ]);

        if (!empty($allowedMimes) && !in_array($mimeType, $allowedMimes)) {
            return false;
        }

        return true;
    }

    /**
     * Check if request origin is valid
     */
    private function isValidOrigin(Request $request): bool
    {
        $referer = $request->headers->get('referer');
        $origin = $request->headers->get('origin');

        // Allow requests without referer/origin (direct API calls)
        if (!$referer && !$origin) {
            return true;
        }

        $appUrl = config('app.url');
        $allowedOrigins = config('filesystems.allowed_origins', [$appUrl]);

        // Check referer
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            $allowedHosts = array_map(function($url) {
                return parse_url($url, PHP_URL_HOST);
            }, $allowedOrigins);

            if (!in_array($refererHost, $allowedHosts)) {
                return false;
            }
        }

        // Check origin
        if ($origin) {
            if (!in_array($origin, $allowedOrigins)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if there's sufficient disk space
     */
    private function hasSufficientDiskSpace(): bool
    {
        $uploadPath = storage_path('app/public');
        $minFreeSpace = config('filesystems.min_free_space', 1024 * 1024 * 100); // 100MB default

        if (!is_dir($uploadPath)) {
            return true; // Directory will be created
        }

        $freeBytes = disk_free_space($uploadPath);

        if ($freeBytes === false) {
            // Can't determine disk space, allow upload
            return true;
        }

        return $freeBytes >= $minFreeSpace;
    }
}
