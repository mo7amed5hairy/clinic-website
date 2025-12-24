<?php

namespace App\Core\Media\Traits;

use App\Core\Media\Jobs\UploadImageJob;

trait HasMediaUpload
{
    public function uploadImageAsync(
        $file,
        string $path,
        string $column
    ): void {
        UploadImageJob::dispatch(
            $file,
            $path,
            static::class,
            $this->id,
            $column
        );
    }
}
