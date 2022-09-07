<?php

namespace App\Http\Controllers;

use App\Services\Uploader\Uploader;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader= $uploader ;
    }

    public function create()
    {
        return view('files.create');
    }

    public function new(Request $request)
    {
        $this->validateFile($request);

        $this->uploader->upload();

        return redirect()->back()->withSuccess('File Has Uploaded Successfuly');
    }

    public function validateFile($request)
    {
        $request->validate([
            'file'=>['required','file','mimetypes:image/jpeg,video/mp4,application/zip'],
        ]);
    }
}
