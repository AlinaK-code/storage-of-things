<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'repair', 'work', 'master'];

    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->foreignId('master')->constrained('users')->after('description');
        });
    }

    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['master']);
            $table->dropColumn('master');
        });
    }

    // кеширование очищяю при сохранении или удалении нового эл
    protected static function booted()
    {
        static::saved(fn () => self::clearCache());
        static::deleted(fn () => self::clearCache());
    }

    public static function clearCache()
    {
        // чищу все ключи, связанные с places
        Cache::forget('places_all_admin');
        Cache::flush();
    }

}