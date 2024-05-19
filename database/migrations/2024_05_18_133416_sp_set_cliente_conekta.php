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
            CREATE PROCEDURE sp_set_cliente_conekta(IN `v_id` BIGINT(20)
                                                              , IN `v_name` VARCHAR(200)
                                                              , IN `v_email` VARCHAR(210)
                                                              , IN `v_phone` VARCHAR(220)
                                                              , IN `v_token_id` VARCHAR(230)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE cliente_conekta 
                  SET name   = v_name
                    , email   = v_email
                    , phone   = v_phone
                    , token_id   = v_token_id
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_cliente_conekta');

    }
};
