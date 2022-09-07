<?php
namespace App\Services\Uploader;

use Illuminate\Http\Request;

class Uploader
{
    private $request;
    private $storageManager;
    private $file;


    public function __construct(Request $request,StorageManager $storageManager)
    {
        $this->request = $request ;
        $this->storageManager = $storageManager ;
        $this->file  = $request->file;
    }

    public function upload()
    {
        $this->putFileIntoStorage();
    }

    private function putFileIntoStorage()
    {
        $method = $this->request->has('is-private')
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
