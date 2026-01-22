<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // есл колонка master уже есть — просто обновляем данные
        DB::table('places')->update(['master' => 1]);

        // делаем колонку NOT NULL и добавляем foreign key
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('master')->nullable(false)->change();
            $table->foreign('master')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['master']);
            $table->unsignedBigInteger('master')->nullable()->change();
        });
    }
};