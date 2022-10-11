<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thermpack extends Model
{
    use HasFactory;
    protected $table = 'tbl_thermopack';
    protected $fillable = [
        'chamber', 'in_temperature', 'out_temperature', 'coal_1', 'coal_2', 'coal_deviation_1', 'coal_deviation_2', 'delta_t', 'delta_t_per', 'chamber_cost', 'chamber_cost_per'
    ];
}
