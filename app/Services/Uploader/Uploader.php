<?php
namespace App\Services\Uploader;

use Illuminate\Http\Request;

class Uploader
{
    private $request;
    private $storageManager;
    private $file;
    private $ffmpeg;


    public function __construct(Request $request,StorageManager $storageManager,FFMpegService $ffmpeg)
    {
        $this->request = $request ;
        $this->storageManager = $storageManager ;
        $this->file  = $request->file;
        $this->ffmpeg  = $ffmpeg;
    }

    public function upload()
    {
        $this->putFileIntoStorage();
        dd($this->ffmpeg->durationOf($this->storageManager->getAbsolutePathOf($this->file->getClientOriginalName(),$this->getType(),$this->isPrivate())));
    }

    private function isPrivate()
    {
        return $this->request->has('is-private');
    }

    private function putFileIntoStorage()
    {
        $method = $this->isPrivate()
            ? 'putFileAsPrivate'
            : 'putFileAsPublic' ;

        $this->storageManager->$method($this->file->getClientOriginalName() , $this->file,$this->getType());
    }

    private function getType()
    {
        return [
            'image/jpeg' => 'image',
            'video/mp4' => 'video',
            'application/zip' => 'archive',
        ][$this->file->getClientMimeType()];
    }
}
