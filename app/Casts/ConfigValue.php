<?php

namespace App\Casts;

use App\Models\File;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use ToneflixCode\LaravelFileable\Media;

class ConfigValue implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->build($value, $attributes['type'], $model);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $type = $attributes['type'];
        $canBeSaved = $value instanceof UploadedFile || (is_array($value) && isset($value[0]) && $value[0] instanceof UploadedFile);

        return match (true) {
            $canBeSaved => $this->doUpload($value, $model),
            is_array($value) => json_encode($value, JSON_FORCE_OBJECT),
            is_bool($value) => $value ? 0 : 1,
            in_array(mb_strtolower($type), ['number', 'integer', 'int']) => (int) $value,
            default => (string) $value,
        };
    }

    /**
     * Upload a file as configuration value
     *
     * @param UploadedFile|UploadedFile[] $files
     * @return string
     */
    public function doUpload(UploadedFile|array $files, Model $model)
    {
        $value = [];

        try {
            if (is_array($files)) {
                $value = collect($files)->map(function (UploadedFile $item, int $index) use ($model) {
                    $file = File::make([
                        'meta' => ['type' => 'configuration', 'key' => $model->key ?? ''],
                        'file' => $item,
                    ]);
                    $file->fileable_id = $model->id ?? null;
                    $file->fileable_type = $model->getMorphClass();
                    $file->fileIndex = $index;
                    $file->save();
                    return $file->id;
                })->toArray();
            } else {
                $file = File::make([
                    'meta' => ['type' => 'configuration', 'key' => $model->key ?? ''],
                    'file' => $files,
                ]);
                $file->fileable_id = $model->id ?? null;
                $file->fileable_type = $model->getMorphClass();
                $file->save();
                $value = [$file->id];
            }
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                $model->key ?? 'value' => $th->getMessage()
            ]);
        }

        return json_encode($value);
    }

    protected function build(mixed $value, string $type, Model $model): mixed
    {
        return match (true) {
            $type === 'file' => $model->files[0]?->file_url ?? (new Media())->getDefaultMedia('default'),
            $type === 'files' => $model->files,
            in_array(mb_strtolower($type), ['bool', 'boolean']) => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            in_array(mb_strtolower($type), ['json', 'array']) => json_decode($value, true),
            in_array(mb_strtolower($type), ['number', 'integer', 'int']) => (int) $value,
            default => $value,
        };
    }
}
