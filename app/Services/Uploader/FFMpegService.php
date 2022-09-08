<?php
namespace App\Services\Uploader;

use FFMpeg\FFprobe;

class FFMpegService
{
    private $ffprobe ;

    public function __construct()
    {
        $this->ffprobe = FFProbe::create([
            'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path'),
        ]);
    }

    public function durationOf(string $path)
    {
        return (int) $this->ffprobe->format($path)->get('duration');
    }
}
