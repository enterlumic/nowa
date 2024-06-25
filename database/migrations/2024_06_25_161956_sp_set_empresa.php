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
        Schema::connection('mysql')->getConnection()->statement('
            CREATE PROCEDURE sp_set_empresa(IN `v_id` BIGINT(20)
                                                              , IN `v_user_id` VARCHAR(200)
                                                              , IN `v_logo` VARCHAR(210)
                                                              , IN `v_nombre` VARCHAR(220)
                                                              , IN `v_descripcion` VARCHAR(230)
                                                              , IN `v_telefono` VARCHAR(240)
                                                              , IN `v_whatsapp` VARCHAR(250)
                                                              , IN `v_ubicacion` VARCHAR(260)
                                                              , IN `v_longitud` VARCHAR(270)
                                                              , IN `v_latitud` VARCHAR(280)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE empresa 
                  SET user_id   = v_user_id
                    , logo   = v_logo
                    , nombre   = v_nombre
                    , descripcion   = v_descripcion
                    , telefono   = v_telefono
                    , whatsapp   = v_whatsapp
                    , ubicacion   = v_ubicacion
                    , longitud   = v_longitud
                    , latitud   = v_latitud
                WHERE id= v_id ;
                SET v_i_response := LAST_INSERT_ID();            
            END
        ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_empresa');

    }
};
