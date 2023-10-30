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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_emisor');
            $table->unsignedBigInteger('id_eda_colab');
            $table->foreign('id_emisor')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->foreign('id_eda_colab')->references('id')->on('eda_colabs')->onDelete('cascade');
            $table->text('feedback')->nullable()->default(null);
            $table->integer('calificacion')->nullable()->default(3);
            $table->boolean('recibido')->default(false);
            $table->timestamp('fecha_recibido')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
