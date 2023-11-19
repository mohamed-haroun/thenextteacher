<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable();
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('tests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_lessons');
    }
};
