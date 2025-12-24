<?php

namespace App\Core\Media\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Filesystem\FilesystemAdapter;

class ImageUploadService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(
            new Driver() // أو Imagick لو متثبت
        );
    }

    public function upload(
        UploadedFile $file,
        string $path,
        int $quality = 75
    ): string {
        $image = $this->imageManager
            ->read($file)
            ->toJpeg($quality);

        $filename = uniqid() . '.jpg';

        Storage::disk('s3')->put(
            "{$path}/{$filename}",
            (string) $image,
            'public'
        );

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url("{$path}/{$filename}");
    }
}
