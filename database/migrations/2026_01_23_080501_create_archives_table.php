<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('wrnt')->nullable();
            $table->string('unit_symbol')->nullable();

            $table->string('owner_name');
            $table->unsignedBigInteger('owner_id');

            $table->string('last_user_name')->nullable();
            $table->unsignedBigInteger('last_user_id')->nullable();

            $table->string('place_name')->nullable();

            $table->boolean('restored')->default(false);
            $table->unsignedBigInteger('restored_by_id')->nullable();
            $table->string('restored_by_name')->nullable();
            $table->timestamp('restored_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};