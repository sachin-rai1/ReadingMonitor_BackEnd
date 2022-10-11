<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineSubCategories extends Model
{
    use HasFactory;
    protected $table = 'tbl_machine_subcategories';
    protected $fillable = [
        'ategories_id', 'sub_name', 'status'    
    ];
}
