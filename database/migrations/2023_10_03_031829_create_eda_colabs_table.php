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
        Schema::create('eda_colabs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_eda');
            $table->foreign('id_eda')->references('id')->on('edas')->onDelete('cascade');
            $table->unsignedBigInteger('id_colaborador');
            $table->foreign('id_colaborador')->references('id')->on('colaboradores')->onDelete('cascade');

            $table->unsignedBigInteger('id_evaluacion');
            $table->foreign('id_evaluacion')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->unsignedBigInteger('id_evaluacion_2');
            $table->foreign('id_evaluacion_2')->references('id')->on('evaluaciones')->onDelete('cascade');

            $table->boolean('enviado')->default(false);
            $table->boolean('aprobado')->default(false);
            $table->boolean('cerrado')->default(false);

            $table->timestamp('fecha_envio')->nullable()->default(null);
            $table->timestamp('fecha_aprobado')->nullable()->default(null);
            $table->timestamp('fecha_cerrado')->nullable()->default(null);

            $table->integer('promedio')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eda_colab');
    }
};
