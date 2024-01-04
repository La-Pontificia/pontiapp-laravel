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
        Schema::create('plantilla_pregunta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_plantilla');
            $table->foreign('id_plantilla')->references('id')->on('plantillas')->onDelete('cascade');
            $table->unsignedBigInteger('id_pregunta');
            $table->foreign('id_pregunta')->references('id')->on('preguntas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_pregunta');
    }
};