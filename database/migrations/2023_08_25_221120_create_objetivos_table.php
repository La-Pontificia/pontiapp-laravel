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
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_colaborador');
            $table->foreign('id_colaborador')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->string('objetivo', 200);
            $table->string('descripcion', 255);
            $table->integer('porcentaje');
            $table->string('indicadores', 255);
            $table->timestamp('fecha_vencimiento')->nullable();
            $table->decimal('puntaje_01');
            $table->timestamp('fecha_calificacion_1')->nullable();
            $table->timestamp('fecha_aprobacion_1')->nullable();
            $table->decimal('puntaje_02');
            $table->timestamp('fecha_calificacion_2')->nullable();
            $table->timestamp('fecha_aprobacion_2')->nullable();
            $table->integer('aprobado')->default(0);
            $table->integer('aprovado_ev_1')->default(0);
            $table->integer('aprovado_ev_2')->default(0);
            $table->string('año_actividad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos');
    }
};
