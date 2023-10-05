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
            $table->unsignedBigInteger('id_transmitter');
            $table->unsignedBigInteger('id_receiver');
            $table->foreign('id_transmitter')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->foreign('id_receiver')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->text('feedback');
            $table->boolean('status');
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
