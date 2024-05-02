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
        Schema::create('pesticide_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesticide_id');
            $table->unsignedBigInteger('criteria_id');
            $table->string('description'); // Deskripsi kriteria
            $table->timestamps();

            $table->foreign('pesticide_id')->references('id')->on('pesticides')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesticide_criteria');
    }
};
