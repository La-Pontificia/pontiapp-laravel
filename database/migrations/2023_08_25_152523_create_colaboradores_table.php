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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();

            $table->string('dni', 8)->required();
            $table->string('apellidos', 40);
            $table->string('nombres', 40);
            $table->string('correo_institucional', 40)->nullable()->default(null);
            $table->string('perfil')->nullable()->default(null);
            $table->integer('rol')->default(0); // 0 = colaborador // 1 = admin // 2 = developer

            $table->integer('estado')->default(1);
            $table->unsignedBigInteger('id_cargo');
            $table->unsignedBigInteger('id_puesto');
            $table->unsignedBigInteger('id_sede');
            $table->unsignedBigInteger('id_supervisor')->nullable()->default(null);

            $table->foreign('id_sede')->references('id')->on('sedes');
            $table->foreign('id_cargo')->references('id')->on('cargos');
            $table->foreign('id_puesto')->references('id')->on('puestos');
            $table->foreign('id_supervisor')->references('id')->on('colaboradores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
