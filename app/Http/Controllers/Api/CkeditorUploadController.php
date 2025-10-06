<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CkeditorUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'upload' => [
                    'required',
                    'file',
                    'max:' . (config('editor.uploads.max_file_size', 5120) / 1024), // Convert to KB
                    'mimes:' . implode(',', config('editor.uploads.allowed_image_types', ['jpg', 'jpeg', 'png', 'gif']))
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => [
                        'message' => $validator->errors()->first('upload')
                    ]
                ], 422);
            }

            $file = $request->file('upload');

            // Generate secure filename
            $extension = $file->getClientOriginalExtension();
            $filename = Str::random(40) . '.' . $extension;

            // Store the file
            $path = $file->storeAs(
                'uploads',
                $filename,
                'public'
            );

            // Generate URL
            $url = Storage::url($path);

            // CKEditor specific response format
            return response()->json([
                'url' => $url,
                'uploaded' => true,
                'fileName' => $file->getClientOriginalName(),
                'size' => $file->getSize()
            ]);

        } catch (\Exception $e) {
            \Log::error('CKEditor upload failed: ' . $e->getMessage());

            return response()->json([
                'error' => [
                    'message' => 'Upload failed. Please try again.'
                ]
            ], 500);
        }
    }

    public function uploadFile(Request $request)
    {
        try {
            // Validation for general file uploads
            $validator = Validator::make($request->all(), [
                'upload' => [
                    'required',
                    'file',
                    'max:' . (config('editor.uploads.max_file_size', 10240) / 1024), // Convert to KB
                    'mimes:' . implode(',', array_merge(
                        config('editor.uploads.allowed_image_types', []),
                        config('editor.uploads.allowed_file_types', [])
                    ))
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => [
                        'message' => $validator->errors()->first('upload')
                    ]
                ], 422);
            }

            $file = $request->file('upload');

            // Check if it's an image or document
            $extension = $file->getClientOriginalExtension();
            $isImage = in_array(strtolower($extension), config('editor.uploads.allowed_image_types', []));

            // Generate secure filename
            $filename = Str::random(40) . '.' . $extension;

            // Store the file in appropriate directory
            $directory = $isImage ? 'uploads/images' : 'uploads/files';
            $path = $file->storeAs($directory, $filename, 'public');

            // Generate URL
            $url = Storage::url($path);

            return response()->json([
                'url' => $url,
                'uploaded' => true,
                'fileName' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $isImage ? 'image' : 'file'
            ]);

        } catch (\Exception $e) {
            \Log::error('CKEditor file upload failed: ' . $e->getMessage());

            return response()->json([
                'error' => [
                    'message' => 'File upload failed. Please try again.'
                ]
            ], 500);
        }
    }
}