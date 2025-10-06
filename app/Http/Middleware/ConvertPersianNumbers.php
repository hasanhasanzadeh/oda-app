<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;

class ConvertPersianNumbers
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->merge($this->convertAllPersianNumbers($request->all()));

        return $next($request);
    }

    /**
     * Convert all Persian numbers in the array to English numbers.
     *
     * @param array $input
     * @return array
     */
    protected function convertAllPersianNumbers(array $input): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->convertAllPersianNumbers($value);
            } elseif (is_string($value)) {
                $input[$key] = Helper::convertPersianToEnglishNumbers($value);
            }
        }

        return $input;
    }
}
