<?php

namespace App\Modules\MediaCenter\Repositories;

use App\Modules\MediaCenter\Contracts\MediaCenterRepositoryInterface;
use App\Modules\MediaCenter\Models\MediaCenter;
use Illuminate\Http\UploadedFile;

class MediaCenterRepository implements MediaCenterRepositoryInterface
{
    public function all()
    {
        return MediaCenter::all();
    }

    public function find($id)
    {
        return MediaCenter::find($id);
    }

    public function create(array $data)
    {
        // تأكد إن path موجود كـ JSON فارغ لتفادي أي خطأ
        $data['path'] = $data['path'] ?? json_encode([]);
        $media = MediaCenter::create($data);

        // رفع الملفات إذا موجودة
        if (!empty($data['files']) && is_array($data['files'])) {
            $uploadedFiles = array_filter($data['files'], fn($f) => $f instanceof UploadedFile);

            if ($data['type'] === 'image') {
                $media->uploadImages($uploadedFiles, 'mediacenter/images', 'path');
            } else {
                $media->uploadVideos($uploadedFiles, 'mediacenter/videos', 'path');
            }
        }

        return $media->refresh();
    }

    public function update($media, array $data)
    {
        // تحديث البيانات الأساسية بدون التأثير على الملفات
        $updateData = $data;
        if (!isset($updateData['path'])) {
            $updateData['path'] = $media->path ?? json_encode([]);
        }
        $media->update($updateData);

        // رفع أو استبدال الملفات إذا موجودة
        if (!empty($data['files']) && is_array($data['files'])) {
            $uploadedFiles = array_filter($data['files'], fn($f) => $f instanceof UploadedFile);
            $mediaType = $data['type'] ?? $media->type;

            if ($mediaType === 'image') {
                $media->replaceImages($uploadedFiles, 'mediacenter/images', 'path');
            } else {
                $media->replaceVideos($uploadedFiles, 'mediacenter/videos', 'path');
            }
        }

        return $media->refresh();
    }

    public function delete($media)
    {
        return $media->delete();
    }
}
