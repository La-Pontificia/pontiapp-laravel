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
        Schema::create('cuestionario_pregunta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cuestionario');
            $table->foreign('id_cuestionario')->references('id')->on('cuestionarios')->onDelete('cascade');
            $table->unsignedBigInteger('id_pregunta');
            $table->foreign('id_pregunta')->references('id')->on('preguntas')->onDelete('cascade');
            $table->string('respuesta', 1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuestionario_pregunta');
    }
};
