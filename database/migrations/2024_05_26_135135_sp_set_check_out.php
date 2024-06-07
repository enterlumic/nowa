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
            CREATE PROCEDURE sp_fnCreateOrder(IN `v_id` BIGINT(20)
                                                              , IN `v_vCampo1_check_out` VARCHAR(200)
                                                              , IN `v_vCampo2_check_out` VARCHAR(210)
                                                              , IN `v_vCampo3_check_out` VARCHAR(220)
                                                              , IN `v_vCampo4_check_out` VARCHAR(230)
                                                              , IN `v_vCampo5_check_out` VARCHAR(240)
                                                              , IN `v_vCampo6_check_out` VARCHAR(250)
                                                              , IN `v_vCampo7_check_out` VARCHAR(260)
                                                              , IN `v_vCampo8_check_out` VARCHAR(270)
                                                              , IN `v_vCampo9_check_out` VARCHAR(280)
                                                              , IN `v_vCampo10_check_out` VARCHAR(290)
                                                              , IN `v_vCampo11_check_out` VARCHAR(300)
                                                              , IN `v_vCampo12_check_out` VARCHAR(310)
                                                              , IN `v_vCampo13_check_out` VARCHAR(320)
                                                              , IN `v_vCampo14_check_out` VARCHAR(330)
                                                              , IN `v_vCampo15_check_out` VARCHAR(340)
                                                              , IN `v_vCampo16_check_out` VARCHAR(350)
                                                              , IN `v_vCampo17_check_out` VARCHAR(360)
                                                              , IN `v_vCampo18_check_out` VARCHAR(370)
                                                              , IN `v_vCampo19_check_out` VARCHAR(380)
                                                              , IN `v_vCampo20_check_out` VARCHAR(390)
                                                              , IN `v_vCampo21_check_out` VARCHAR(400)
                                                              , IN `v_vCampo22_check_out` VARCHAR(410)
                                                              , IN `v_vCampo23_check_out` VARCHAR(420)
                                                              , IN `v_vCampo24_check_out` VARCHAR(430)
                                                              , IN `v_vCampo25_check_out` VARCHAR(440)
                                                              , IN `v_vCampo26_check_out` VARCHAR(450)
                                                              , IN `v_vCampo27_check_out` VARCHAR(460)
                                                              , IN `v_vCampo28_check_out` VARCHAR(470)
                                                              , IN `v_vCampo29_check_out` VARCHAR(480)
                                                              , IN `v_vCampo30_check_out` VARCHAR(490)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE check_out 
                  SET vCampo1_check_out   = v_vCampo1_check_out
                    , vCampo2_check_out   = v_vCampo2_check_out
                    , vCampo3_check_out   = v_vCampo3_check_out
                    , vCampo4_check_out   = v_vCampo4_check_out
                    , vCampo5_check_out   = v_vCampo5_check_out
                    , vCampo6_check_out   = v_vCampo6_check_out
                    , vCampo7_check_out   = v_vCampo7_check_out
                    , vCampo8_check_out   = v_vCampo8_check_out
                    , vCampo9_check_out   = v_vCampo9_check_out
                    , vCampo10_check_out   = v_vCampo10_check_out
                    , vCampo11_check_out   = v_vCampo11_check_out
                    , vCampo12_check_out   = v_vCampo12_check_out
                    , vCampo13_check_out   = v_vCampo13_check_out
                    , vCampo14_check_out   = v_vCampo14_check_out
                    , vCampo15_check_out   = v_vCampo15_check_out
                    , vCampo16_check_out   = v_vCampo16_check_out
                    , vCampo17_check_out   = v_vCampo17_check_out
                    , vCampo18_check_out   = v_vCampo18_check_out
                    , vCampo19_check_out   = v_vCampo19_check_out
                    , vCampo20_check_out   = v_vCampo20_check_out
                    , vCampo21_check_out   = v_vCampo21_check_out
                    , vCampo22_check_out   = v_vCampo22_check_out
                    , vCampo23_check_out   = v_vCampo23_check_out
                    , vCampo24_check_out   = v_vCampo24_check_out
                    , vCampo25_check_out   = v_vCampo25_check_out
                    , vCampo26_check_out   = v_vCampo26_check_out
                    , vCampo27_check_out   = v_vCampo27_check_out
                    , vCampo28_check_out   = v_vCampo28_check_out
                    , vCampo29_check_out   = v_vCampo29_check_out
                    , vCampo30_check_out   = v_vCampo30_check_out
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_check_out');

    }
};
