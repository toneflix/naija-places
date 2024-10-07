<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;

    protected $table = 'world_cities';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'flag' => 'boolean',
        ];
    }
}