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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('title')->unique();
            $table->integer('chapter');
            $table->enum('term', ['first', 'second'])->default('first');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('grade_id');
            $table->timestamps();

            $table->unique(['code', 'chapter', 'subject_id', 'term']);

            $table->foreign('grade_id')->references('id')->on('grades')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
