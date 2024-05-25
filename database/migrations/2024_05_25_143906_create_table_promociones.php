<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('fotos', 255)->nullable(); // Imagen asociada con la promoción, incrementado a 255 caracteres
            $table->string('titulo', 800)->nullable(); // Título de la promoción, incrementado a 100 caracteres
            $table->text('descripcion')->nullable(); // Descripción más larga de la promoción
            $table->string('precio')->nullable(); // Precio actual, con 8 dígitos en total y 2 decimales
            $table->string('marca', 50)->nullable(); // Marca asociada con la promoción, incrementado a 50 caracteres
            $table->text('review')->nullable(); // Revisión o comentario
            $table->string('cantidad')->nullable(); // Cantidad asociada con la promoción
            $table->string('color', 30)->nullable(); // Color asociado con la promoción
            $table->string('precio_anterior')->nullable(); // Precio anterior, con 8 dígitos en total y 2 decimales
            $table->text('target')->nullable(); // Target asociado con la promoción, incrementado a 100 caracteres

            $table->timestamps(); // created_at y updated_at automáticos
            $table->boolean('b_status')->index()->default(1); // Estado de la promoción (1 = activo)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promociones');
    }
};
