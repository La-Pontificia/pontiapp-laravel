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
            $table->integer('estado')->default(0); // 0 NO ENVIADO | 1 PENDIENTE | 3 APROBADO | 4 AUTOCALIFICADO | 5 CERRADO
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
