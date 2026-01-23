<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'name', 'description', 'wrnt', 'unit_symbol',
        'owner_name', 'owner_id',
        'last_user_name', 'last_user_id',
        'place_name',
        'restored', 'restored_by_id', 'restored_by_name', 'restored_at'
    ];

    protected $casts = [
        'restored' => 'boolean',
        'restored_at' => 'datetime', 
        'wrnt' => 'date',
    ];
}