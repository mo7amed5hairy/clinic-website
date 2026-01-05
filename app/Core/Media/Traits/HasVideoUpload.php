<?php

namespace App\Core\Media\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasVideoUpload
{
    public function uploadVideo(
        ?UploadedFile $file,
        array $options = []
    ): ?string {
        if (!$file) {
            return null;
        }

        $disk   = $options['disk']   ?? 'public';
        $folder = trim($options['folder'] ?? 'videos', '/');
        $column = $options['column'] ?? null;
        $name   = $options['name']   ?? Str::uuid()->toString();

        $extension = $file->getClientOriginalExtension();
        $filename  = "{$name}.{$extension}";

        $path = $file->storeAs($folder, $filename, $disk);

        if (!$column) {
            return $path;
        }

        $this->update([
            $column => $path,
        ]);

        return $path;
    }

    public function replaceVideo(?UploadedFile $file, array $options = []): ?string
    {
        if (!$file) {
            return null;
        }

        $disk   = $options['disk']   ?? 'public';
        $column = $options['column'] ?? null;

        if ($column && $this->{$column}) {
            if (Storage::disk($disk)->exists($this->{$column})) {
                Storage::disk($disk)->delete($this->{$column});
            }
        }

        return $this->uploadVideo($file, $options);
    }
}
