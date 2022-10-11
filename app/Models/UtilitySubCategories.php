<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilitySubCategories extends Model
{
    use HasFactory;
    protected $table = 'tbl_uitility_subcategories';
    protected $fillable = [
        'uitility_categories_id', 'uilitysubc_name', 'status'
    ];
    public function utilitycategory()
    {
        return $this->hasMany(UtilityCategories::class, 'uitility_categories_id');
    }
}
