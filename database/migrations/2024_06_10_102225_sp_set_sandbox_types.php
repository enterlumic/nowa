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
            CREATE PROCEDURE sp_set_sandbox_types(IN `v_id` BIGINT(20)
                                                              , IN `v_name` VARCHAR(200)
                                                              , IN `v_description` VARCHAR(210)
                                                              , IN `v_is_sandbox` VARCHAR(220)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE sandbox_types 
                  SET name   = v_name
                    , description   = v_description
                    , is_sandbox   = v_is_sandbox
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_sandbox_types');

    }
};
