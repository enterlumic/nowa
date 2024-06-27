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
            CREATE PROCEDURE sp_set_productos(IN `v_id` BIGINT(20)
                                                              , IN `v_fotos` VARCHAR(200)
                                                              , IN `v_titulo` VARCHAR(210)
                                                              , IN `v_descripcion` VARCHAR(220)
                                                              , IN `v_precio` VARCHAR(230)
                                                              , IN `v_marca` VARCHAR(240)
                                                              , IN `v_review` VARCHAR(250)
                                                              , IN `v_cantidad` VARCHAR(260)
                                                              , IN `v_color` VARCHAR(270)
                                                              , IN `v_precio_anterior` VARCHAR(280)
                                                              , IN `v_target` VARCHAR(290)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE productos 
                  SET fotos   = v_fotos
                    , titulo   = v_titulo
                    , descripcion   = v_descripcion
                    , precio   = v_precio
                    , marca   = v_marca
                    , review   = v_review
                    , cantidad   = v_cantidad
                    , color   = v_color
                    , precio_anterior   = v_precio_anterior
                    , target   = v_target
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_productos');

    }
};
