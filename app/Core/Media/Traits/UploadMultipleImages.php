<?php

namespace App\Core\Media\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadMultipleImages
{
    public function uploadImages(array $images, string $folder = 'media/images', string $column = 'path')
    {
        $paths = [];
        foreach ($images as $image) {
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $path = $image->storeAs($folder, $filename, 'public');
            $paths[] = $path;
        }

        $this->{$column} = json_encode($paths, JSON_UNESCAPED_SLASHES);
        $this->save();


        return $paths;
    }

    public function replaceImages(array $images, string $folder = 'media/images', string $column = 'path')
    {
        // حذف الملفات القديمة
        if ($this->{$column}) {
            $oldPaths = json_decode($this->{$column}, true);
            foreach ($oldPaths as $old) {
                Storage::disk('public')->delete($old);
            }
        }

        // رفع الملفات الجديدة
        return $this->uploadImages($images, $folder, $column);
    }
}
