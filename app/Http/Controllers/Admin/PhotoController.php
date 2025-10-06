<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{


    public function uploadImage(Request $request): void
    {
        if ($request->hasFile('upload')) {
            $uploadedFile = $request->file('upload');
            $filename = time() . $uploadedFile->getClientOriginalName();
            $original_name = $uploadedFile->getClientOriginalName();
            Storage::disk('public')->putFileAs(
                'uploads/images', $uploadedFile, $filename
            );
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = ENV('APP_URL') . '/storage/uploads/images/' . $filename;

            $msg = __('dashboard.success');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

}
