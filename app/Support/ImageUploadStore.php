<?php

namespace App\Support;

use App\Models\MediaUpload;
use Illuminate\Http\UploadedFile;

class ImageUploadStore
{
    public function store(UploadedFile $file): string
    {
        $media = MediaUpload::create([
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'contents' => base64_encode($file->getContent()),
        ]);

        return 'media:'.$media->id;
    }

    public function delete(?string $reference): void
    {
        if (! $reference || ! str_starts_with($reference, 'media:')) {
            return;
        }

        MediaUpload::whereKey((int) str($reference)->after('media:')->toString())->delete();
    }
}
