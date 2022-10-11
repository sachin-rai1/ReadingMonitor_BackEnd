<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineCategories extends Model
{
    use HasFactory;
    protected $table = 'tbl_machine_categories';
    protected $fillable = [
        'categories', 'status'  
    ];
}
