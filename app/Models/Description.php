<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;

    protected $fillable = ['thing_id', 'content', 'is_current'];

    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}