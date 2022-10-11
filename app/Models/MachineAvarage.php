<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineAvarage extends Model
{
    use HasFactory;
    protected $table = 'tbl_machine_average';
    protected $fillable = [
        'sub_categories_id', 'em', 'hm', 'em_hm_total', 'em_hm_percentage', 'water_batch', 'water_batch_per'  
    ];
}
