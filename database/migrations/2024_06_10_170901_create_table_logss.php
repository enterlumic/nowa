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
        Schema::connection('mysql')->create('logss', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID del usuario relacionado con el log');
            $table->string('event_type')->comment('Tipo de evento');
            $table->text('context')->nullable()->comment('Información adicional relacionada con el evento');
            $table->text('event_data')->nullable()->comment('Datos relacionados con el evento');
            $table->string('execution_time')->nullable()->comment('Tiempo de ejecución del evento en milisegundos');
            $table->string('status')->nullable()->comment('Estado del evento (éxito/fallo)');
            $table->string('severity')->nullable()->comment('Nivel de severidad del evento (info, warning, error)');
            $table->string('source')->nullable()->comment('Fuente del evento (sistema, usuario, api)');
            $table->string('ip_address')->nullable()->comment('Dirección IP desde donde se realizó el evento');
            $table->string('user_agent')->nullable()->comment('Cadena del agente de usuario del navegador o dispositivo');
            $table->text('description')->nullable()->comment('Descripciones adicionales o detalles del evento');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->boolean('b_status')->index()->default(1);

            // Índices
            $table->index('user_id')->comment('Índice para búsquedas más rápidas en user_id');
            $table->index('event_type')->comment('Índice para búsquedas más rápidas en event_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logss');
    }
};
