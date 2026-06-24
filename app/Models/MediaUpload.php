<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    protected $fillable = [
        'filename',
        'mime_type',
        'size',
        'contents',
    ];

    public function bytes(): string
    {
        return base64_decode($this->contents, true) ?: '';
    }
}
