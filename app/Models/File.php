<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use ToneflixCode\LaravelFileable\Media;

class File extends Model
{
    protected $fillable = [
        'model',
        'meta',
        'file',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'meta' => '{}',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'file_url',
        'shared_url',
    ];

    public ?int $fileIndex = null;

    /**
     * Map fileable to a collection
     *
     * @var array<class-string, string>
     *
     * @example $mediaPaths [User::class => 'avatar', Configuration::class => 'default']
     */
    public $mediaPaths = [];

    protected static function booted()
    {
        static::saving(function (File $file) {
            $meta_type = isset($file->meta['type']) ? ".{$file->meta['type']}" : '';

            $mediaPath = $file->mediaPaths[$file->fileable_type . $meta_type] ?? 'default';

            $file->file = (new Media())->save($mediaPath, 'file', $file->file, $file->fileIndex);

            if (!$file->file) {
                unset($file->file);
            }

            if (!$file->meta) {
                unset($file->meta);
            }
        });

        static::deleted(function (File $file) {
            $meta_type = isset($file->meta['type']) ? ".{$file->meta['type']}" : '';

            $mediaPath = $file->mediaPaths[$file->fileable_type . $meta_type] ?? 'default';

            $file->file = (new Media())->delete($mediaPath, $file->file);
        });
    }

    /**
     * Get the parent fileable model (album or vision board).
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get posibly protected URL of the image.
     */
    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $meta_type = isset($this->meta['type']) ? ".{$this->meta['type']}" : '';

                $mediaPath = $this->mediaPaths[$this->fileable_type . $meta_type] ?? 'default';

                if (!str($mediaPath)->exactly('default')) {
                    $wt = '?preload=true';

                    $superLoad = Auth::user()->hasRole(config('permission-defs.elevated-roles', []));
                    $uid = Auth::id() ?: 0;

                    // Check if the user has elevated access and append some random query you
                    // Can use later
                    if ($superLoad) {
                        $wt = '?preload=true&wt=' . (Auth::user()->window_token ?? rand());
                    } elseif ($this->fileable && $this->fileable->user->id === $uid) {
                        $wt = '?preload=true&wt=' . ($this->fileable->user->window_token ?? rand());
                    }

                    // Append more queries you can use later
                    $wt .= '&ctx=' . rand();
                    $wt .= '&build=' . AppInfo::basic()['version'] ?? '1.0.0';
                    $wt .= '&mode=' . config('app.env');
                    $wt .= '&pov=' . md5($this->file);
                }

                return (new Media())->getMedia($mediaPath, $this->file);
            },
        );
    }

    public function progress(): Attribute
    {
        return new Attribute(
            get: function () {
                $diskName = 'streamable_media';

                $meta_type = isset($this->meta['type']) ? ".{$this->meta['type']}" : '';

                $mediaPath = $this->mediaPaths[$this->fileable_type . $meta_type] ?? 'default';

                if ($mediaPath === 'private.music') {
                    $diskName = 'gpaf_media';
                }

                $progress = 0;

                if ($this->fileable->processed_at) {
                    return 100;
                } elseif ($diskName === 'gpaf_media') {
                    $progress = Cache::get('media.segment.' . str($this->file . '.' . $this->id)->toString(), 0);
                }

                return $progress;
            },
        );
    }

    public function progressComplete(): Attribute
    {
        return new Attribute(
            get: fn () => $this->progress >= 100 ? '100% completed!' : "{$this->progress}% processing...",
        );
    }

    /**
     * Get a shared/public URL of the image.
     *
     * @return string
     */
    protected function sharedUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $meta_type = isset($this->meta['type']) ? ".{$this->meta['type']}" : '';

                $mediaPath = $this->mediaPaths[$this->fileable_type . $meta_type] ?? 'default';

                if (!str($mediaPath)->exactly('default')) {
                    $window_token = Auth::user() ? Auth::user()->window_token : 0;

                    // Append some query params you can use later
                    $wt = '?preload=true&shared&wt=' . $window_token;
                    $wt .= '&ctx=' . rand();
                    $wt .= '&build=' . AppInfo::basic()['version'] ?? '1.0.0';
                    $wt .= '&mode=' . config('app.env');
                    $wt .= '&pov=' . md5($this->file);
                }

                return (new Media())->getMedia($mediaPath, $this->file);
            },
        );
    }
}
