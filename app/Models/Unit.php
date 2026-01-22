<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    // поле название (например, штуки) и символ, например, "шт"
    protected $fillable = ['name', 'symbol'];
}
