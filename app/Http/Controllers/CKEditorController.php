<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();

            // storage/app/public/ckeditor me save hoga
            $file->storeAs('public/ckeditor', $filename);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/ckeditor/' . $filename); // symlink ke through public URL
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}