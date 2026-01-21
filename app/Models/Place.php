<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}