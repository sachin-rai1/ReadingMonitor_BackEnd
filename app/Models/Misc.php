<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{
    use HasFactory;
    protected $table = 'tbl_misc';
    protected $fillable = [
        'categories_id', 'unit', 'deviation', 'status'
    ];
}
