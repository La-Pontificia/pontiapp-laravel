<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('dni', 8)->required();
            $table->json('privilegios')->nullable()->default(null);
            $table->string('apellidos', 40);
            $table->string('nombres', 40);
            $table->string('correo_institucional', 40)->nullable()->default(null);
            $table->string('perfil')->default('/default-user.webp');
            $table->enum('rol', [0, 1, 2]); // 0 = colaborador // 1 = admin // 2 = developer

            $table->integer('estado')->default(1);

            $table->uuid('id_cargo')->references('id')->on('cargos')->onDelete('cascade');
            $table->uuid('id_sede')->references('id')->on('sedes')->onDelete('cascade');
            $table->uuid('id_supervisor')->nullable()->default(null);

            $table->timestamps();
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->foreign('id_supervisor')->references('id')->on('colaboradores');
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->index('id_supervisor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
