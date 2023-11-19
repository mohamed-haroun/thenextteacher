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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_type_id');
            $table->integer('count');
            $table->unsignedBigInteger('test_type_id');
            $table->timestamps();

            $table->foreign('test_type_id')->references('id')->on('test_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('question_type_id')->references('id')->on('question_types')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
