<?php

namespace App\Helpers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class Helper
{

    public static function maxFileUpload(): string
    {
        return config('file-upload.max_file_upload');
    }

    public static function maxVideoUpload():string
    {
        return config('file-upload.max_video_upload');
    }
    public static function convertPersianToEnglishNumbers($input): array|string
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persianNumbers, $englishNumbers, $input);
    }

    public static function shortNumber($num, $precision = 1)
    {
                if ($num < 1000) {
                    return $num;
                }
                $units = ['', 'K', 'M', 'B', 'T'];
                $power = floor(log($num, 1000));
                return round($num / (1000 ** $power), $precision) . $units[$power];

    }
    public static function slugMake($slug): string
    {
        $string=str_replace(['/',"\\",'%','#','!','@','$','^','&','*','(',')','_','=',"'",'"','|'],'',$slug);
        return preg_replace('/\s+/u', '-', trim($string));
    }

    public static function deleteFile(string $url): bool
    {
        if (Storage::disk('public')->exists($url)) {
            return Storage::disk('public')->delete($url);
        }
        return false;
    }

    public static function uploadImageVerify($file)
    {
        $path = $file->store('verifies', 'private');
        $file = File::create(['path' => $path]);
        return  $file->id;
    }

    public static function uploadImage($file)
    {
        $path = str_replace('public', 'storage', $file->store('public/files'));
        $file = File::create(['path' => $path]);
        return  $file->id;
    }

    public static function uploadVideo($file)
    {
        $path = str_replace('public', 'storage', $file->store('public/videos'));
        $file = File::create(['path' => $path]);
        return  $file->id;
    }
}
