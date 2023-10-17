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
            $table->integer('estado')->default(0); // 0 PENDIENTE | 1 ENVIADO | 2 APROBADO | 3 CERRADO
            $table->integer('feedback_estado')->default(0); // 0 PENDIENTE | 1 ENVIADO | 2 ACEPTADO
            $table->string('feedback_descripcion')->nullable()->default(null);
            $table->unsignedBigInteger('feedback_supervisor')->nullable()->default(null);
            $table->foreign('feedback_supervisor')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->integer('cant_obj')->default(0);
            $table->integer('nota_final')->default(0);
            $table->integer('wearing')->default(0); // SI SE ESTA USANDO ESTA EDA EL COLABORADOR
            $table->timestamp('f_envio')->nullable()->default(null);
            $table->timestamp('f_aprobacion')->nullable()->default(null);
            $table->timestamp('f_cerrado')->nullable()->default(null);
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
