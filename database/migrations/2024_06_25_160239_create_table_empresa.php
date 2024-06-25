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
        Schema::connection('mysql')->create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 100)->nullable()->comment('Agregar lodo de tu empresa');
            $table->string('nombre', 60)->nullable()->comment('Nombre de la empresa');
            $table->text('descripcion')->nullable()->comment('Descripción de la empresa');
            $table->string('telefono', 15)->nullable()->comment('Teléfono de contacto de la empresa');
            $table->string('whatsapp', 15)->nullable()->comment('Numero que tenga whatsapp');
            $table->string('ubicacion', 120)->nullable()->comment('Ubicación de la empresa');
            $table->string('longitud', 30)->nullable();
            $table->string('latitud', 30)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Fecha de creación del registro');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Fecha de actualización del registro');
            $table->boolean('b_status')->index()->default(1)->comment('Estado de la empresa (1 = Activo, 0 = Inactivo)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
};
