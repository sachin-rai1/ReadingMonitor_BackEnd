<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityCategories extends Model
{
    use HasFactory;
    protected $table = 'tbl_uitility_categories';
    protected $fillable = [
        'uitility_categories', 'status'
    ];
}
