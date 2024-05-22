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
        Schema::connection('mysql')->create('cliente_conekta', function (Blueprint $table) {
            $table->id();
            $table->string('id_conekta', 26)->nullable()->comment('ID de Conekta');
            $table->string('name', 30)->nullable()->comment('Nombre del cliente');
            $table->string('number', 30)->nullable()->comment('Número de tarjeta');
            $table->string('cvc', 5)->nullable()->comment('Código de seguridad');
            $table->string('exp_month', 5)->nullable()->comment('Mes de expiración');
            $table->string('exp_year', 5)->nullable()->comment('Año de expiración');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Fecha de creación');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Fecha de actualización');
            $table->boolean('b_status')->index()->default(1)->comment('Estado del cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_conekta');
    }
};
