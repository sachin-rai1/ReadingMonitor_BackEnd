<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterQuilty extends Model
{
    use HasFactory;
    protected $table = 'tbl_water_quality';
    protected $fillable = [
        'categories_id', 'tds', 'tds_percentage', 'ph', 'ph_deviation', 'hardness', 'hardness_percentage', 'status'
    ];
}
