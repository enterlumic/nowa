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
            CREATE PROCEDURE sp_set_logss(IN `v_id` BIGINT(20)
                                                              , IN `v_user_id` VARCHAR(200)
                                                              , IN `v_event_type` VARCHAR(210)
                                                              , IN `v_context` VARCHAR(220)
                                                              , IN `v_event_data` VARCHAR(230)
                                                              , IN `v_execution_time` VARCHAR(240)
                                                              , IN `v_status` VARCHAR(250)
                                                              , IN `v_severity` VARCHAR(260)
                                                              , IN `v_source` VARCHAR(270)
                                                              , IN `v_ip_address` VARCHAR(280)
                                                              , IN `v_user_agent` VARCHAR(290)
                                                              , IN `v_description` VARCHAR(300)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE logss 
                  SET user_id   = v_user_id
                    , event_type   = v_event_type
                    , context   = v_context
                    , event_data   = v_event_data
                    , execution_time   = v_execution_time
                    , status   = v_status
                    , severity   = v_severity
                    , source   = v_source
                    , ip_address   = v_ip_address
                    , user_agent   = v_user_agent
                    , description   = v_description
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_logss');

    }
};
