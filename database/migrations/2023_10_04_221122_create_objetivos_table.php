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
            $table->unsignedBigInteger('id_eda_colab');
            $table->foreign('id_eda_colab')->references('id')->on('eda_colabs')->onDelete('cascade');
            //
            $table->string('objetivo', 255);
            $table->string('descripcion', 2000);
            $table->string('indicadores', 2000);
            $table->decimal('porcentaje', 5, 2);
            $table->integer('autoevaluacion')->default(0);
            $table->integer('nota')->default(0);
            $table->integer('editado')->default(0);
            $table->timestamp('nota_fecha')->nullable();
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
