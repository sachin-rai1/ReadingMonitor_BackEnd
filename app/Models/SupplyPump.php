<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyPump extends Model
{
    use HasFactory;
    protected $table = 'tbl_supply_pump';
    protected $fillable = [
        'categories_id', 'average', 'deviation', 'status'
    ];
}
