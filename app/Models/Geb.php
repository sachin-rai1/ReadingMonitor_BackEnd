<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geb extends Model
{
    use HasFactory;
    protected $table = 'tbl_geb';
    protected $fillable = [
        'kwh', 'kwm_deviation', 'kvarsh_deviation', 'kevah', 'kevah_deviation', 'pf', 'pf_deviation', 'md', 
         'md_deviation', 'turbine', 'turbine_deviation', 'status'    
    ];
}
