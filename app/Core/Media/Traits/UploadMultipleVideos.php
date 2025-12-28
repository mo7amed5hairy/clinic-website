<?php

namespace App\Core\Media\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadMultipleVideos
{
    public function uploadVideos(array $videos, string $folder = 'media/videos', string $column = 'path')
    {
        $paths = [];
        foreach ($videos as $video) {
            $ext = $video->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $path = $video->storeAs($folder, $filename, 'public');
            $paths[] = $path;
        }

        $this->{$column} = json_encode($paths, JSON_UNESCAPED_SLASHES);
        $this->save();


        return $paths;
    }

    public function replaceVideos(array $videos, string $folder = 'media/videos', string $column = 'path')
    {
        if ($this->{$column}) {
            $oldPaths = json_decode($this->{$column}, true);
            foreach ($oldPaths as $old) {
                Storage::disk('public')->delete($old);
            }
        }

        return $this->uploadVideos($videos, $folder, $column);
    }
}
