<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityAvarege extends Model
{
    use HasFactory;
    protected $table = 'tbl_utility_average';
    protected $fillable = [
        'uitility_subcategories_id', 'em', 'hm', 'em_hm', 'em_hm_per'
    ];
}
