<?php
namespace App\Modules\ClinicNews\Repositories;

use App\Modules\ClinicNews\Models\ClinicNews;
use App\Modules\ClinicNews\Contracts\ClinicNewsRepositoryInterface;

class ClinicNewsRepository implements ClinicNewsRepositoryInterface
{
    public function all() {
        return ClinicNews::all();
    }

    public function find(int $id): ?ClinicNews {
        return ClinicNews::find($id);
    }

    public function create(array $data): ClinicNews {
        return ClinicNews::create($data);
    }

    public function update(ClinicNews $news, array $data): ClinicNews {
        $news->update($data);
        return $news;
    }

    public function delete(ClinicNews $news): bool {
        return $news->delete();
    }
}
