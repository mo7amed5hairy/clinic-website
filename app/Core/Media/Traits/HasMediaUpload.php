<?php

namespace App\Core\Media\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasMediaUpload
{
    public function uploadImage(
        ?UploadedFile $file,
        array $options = []
    ): ?string {
        if (!$file) {
            return null;
        }

        $disk   = $options['disk']   ?? 'public';
        $folder = trim($options['folder'] ?? 'uploads', '/');
        $column = $options['column'] ?? null;
        $name   = $options['name']   ?? Str::uuid()->toString();

        // الامتداد
        $extension = $file->getClientOriginalExtension();
        $filename  = "{$name}.{$extension}";

        // التخزين
        $path = $file->storeAs($folder, $filename, $disk);

        // لو مش عايز تخزين في DB
        if (!$column) {
            return $path;
        }

        // JSON column support (example: doctor_data->image)
        if (str_contains($column, '->')) {
            [$jsonColumn, $jsonKey] = explode('->', $column, 2);

            $data = (array) $this->{$jsonColumn};
            $data[$jsonKey] = $path;

            $this->update([
                $jsonColumn => $data,
            ]);
        } else {
            $this->update([
                $column => $path,
            ]);
        }

        return $path;
    }

    /**
     * استبدال الصورة القديمة بالجديدة
     */
    public function replaceImage(?UploadedFile $file, array $options = []): ?string
    {
        if (!$file) {
            return null;
        }

        $disk   = $options['disk']   ?? 'public';
        $column = $options['column'] ?? null;

        // حذف الصورة القديمة لو موجودة
        if ($column) {
            $oldPath = $this->getColumnValue($column);
            if ($oldPath && Storage::disk($disk)->exists($oldPath)) {
                Storage::disk($disk)->delete($oldPath);
            }
        }

        // رفع الصورة الجديدة
        return $this->uploadImage($file, $options);
    }

    /**
     * دوال مساعدة للـ JSON column support
     */
    protected function setColumn(string $column, string $path)
    {
        if (str_contains($column, '->')) {
            [$jsonColumn, $jsonKey] = explode('->', $column, 2);
            $data = (array) $this->{$jsonColumn};
            $data[$jsonKey] = $path;
            $this->update([$jsonColumn => $data]);
        } else {
            $this->update([$column => $path]);
        }
    }

    protected function getColumnValue(string $column)
    {
        if (str_contains($column, '->')) {
            [$jsonColumn, $jsonKey] = explode('->', $column, 2);
            $data = (array) $this->{$jsonColumn};
            return $data[$jsonKey] ?? null;
        }
        return $this->{$column};
    }
}







