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
        Schema::connection('mysql')->create('empleados', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 255);
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->date('fecha_ingreso');
            $table->string('puesto', 100);
            $table->string('salario')->nullable();
            $table->string('jornada', 50)->nullable();
            $table->string('especialidades', 255)->nullable();
            $table->string('certificaciones', 255)->nullable();
            $table->string('usuario', 50);
            $table->string('contrasenia', 255);
            $table->string('estado', 50)->nullable();
            $table->boolean('b_status')->index()->default(1);            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
};
