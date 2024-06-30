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
            CREATE PROCEDURE sp_set_carrito(IN `v_id` BIGINT(20)
                                                              , IN `v_user_id` VARCHAR(200)
                                                              , IN `v_producto_id` VARCHAR(210)
                                                              , IN `v_cantidad` VARCHAR(220)
                                                              , IN `v_agregado_en` VARCHAR(230)
                                                              , IN `v_estado` VARCHAR(240)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE carrito 
                  SET user_id   = v_user_id
                    , producto_id   = v_producto_id
                    , cantidad   = v_cantidad
                    , agregado_en   = v_agregado_en
                    , estado   = v_estado
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_carrito');

    }
};
