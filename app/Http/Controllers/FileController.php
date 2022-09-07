<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function create()
    {
        return view('files.create');
    }

    public function new(Request $request)
    {
        $this->validateFile($request);

        dd($request->file);
    }

    public function validateFile($request)
    {
        $request->validate([
            'file'=>['required','file','mimetypes:image/jpeg,video/mp4,application/zip'],
        ]);
    }
}
