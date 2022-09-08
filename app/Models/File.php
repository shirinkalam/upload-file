<?php

namespace App\Models;

use App\Services\Uploader\StorageManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'size',
        'time',
        'is_private'
    ];

    public function isMedia()
    {
        return $this->type == 'video';
    }

    public function absolutePath()
    {
        return resolve(StorageManager::class)->getAbsolutePathOf($this->name,$this->type,$this->is_private);
    }
}
