<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('things', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->constrained()->after('wrnt');
        });
    }

    public function down()
    {
        // при удалении ед измерения удалить поле в столбце и ссылку на FK
        Schema::table('things', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
    }
};
