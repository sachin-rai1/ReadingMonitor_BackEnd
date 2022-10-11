<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamBoiler extends Model
{
    use HasFactory;
    protected $table = 'tbl_steam_boiler';
    protected $fillable = [
        'bfw', 'temperature', 'bfw_percentage', 'bfw_temperature_percentage', 'coal_1', 'coal_2', 'coal_deviation_1', 'coal_deviation_2', 'rate_of_coal_1', 'rate_of_coal_2', 'steam_cost', 'status'
    ];
}
