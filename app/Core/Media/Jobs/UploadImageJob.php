<?php

namespace App\Core\Media\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Core\Media\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;

class UploadImageJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        protected UploadedFile $file,
        protected string $path,
        protected string $modelClass,
        protected int $modelId,
        protected string $column
    ) {}

    public function handle(ImageUploadService $service)
    {
        $url = $service->upload($this->file, $this->path);

        ($this->modelClass)::where('id', $this->modelId)
            ->update([$this->column => $url]);
    }
}
