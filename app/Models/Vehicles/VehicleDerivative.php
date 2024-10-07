<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDerivative extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;
}