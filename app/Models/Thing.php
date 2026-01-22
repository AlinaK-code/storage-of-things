<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Cache; // для кэширования


class Thing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'wrnt', 'master', 'unit_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'master');
    }

    public function uses()
    {
        return $this->hasMany(UseRecord::class, 'thing_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}