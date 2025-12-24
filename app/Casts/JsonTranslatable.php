<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonTranslatable implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $data = json_decode($value, true) ?? [];

        return $this->translateNested($data);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    protected function translateNested(array $data): array
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');

        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value[$locale])) {
                $data[$key] = $value[$locale]
                    ?? $value[$fallback]
                    ?? null;
            }
        }

        return $data;
    }
}
