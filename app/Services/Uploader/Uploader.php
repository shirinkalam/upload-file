<?php
namespace App\Services\Uploader;

use App\Models\File;
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

        $this->saveFileIntoDatabase();
    }

    private function saveFileIntoDatabase()
    {
        $file = new File([
            'name' =>$this->file->getClientOriginalName(),
            'size' =>$this->file->getSize(),
            'type' =>$this->getType(),
            'is_private' =>$this->isPrivate()
        ]);

        $file->time = $this->getTime($file);

        $file->save();
    }

    private function getTime(File $file)
    {
        if(!$file->isMedia()) return null ;

        return $this->ffmpeg->durationOf($file->absolutePath());

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
