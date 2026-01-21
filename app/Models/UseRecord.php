<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseRecord extends Model
{
    use HasFactory;

    protected $table = 'uses';

    // Разрешаю массовое заполнение
    protected $fillable = ['thing_id', 'place_id', 'user_id', 'amount'];
}