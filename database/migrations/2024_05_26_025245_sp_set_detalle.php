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
            CREATE PROCEDURE sp_set_detalle(IN `v_id` BIGINT(20)
                                                              , IN `v_vCampo1_detalle` VARCHAR(200)
                                                              , IN `v_vCampo2_detalle` VARCHAR(210)
                                                              , IN `v_vCampo3_detalle` VARCHAR(220)
                                                              , IN `v_vCampo4_detalle` VARCHAR(230)
                                                              , IN `v_vCampo5_detalle` VARCHAR(240)
                                                              , IN `v_vCampo6_detalle` VARCHAR(250)
                                                              , IN `v_vCampo7_detalle` VARCHAR(260)
                                                              , IN `v_vCampo8_detalle` VARCHAR(270)
                                                              , IN `v_vCampo9_detalle` VARCHAR(280)
                                                              , IN `v_vCampo10_detalle` VARCHAR(290)
                                                              , IN `v_vCampo11_detalle` VARCHAR(300)
                                                              , IN `v_vCampo12_detalle` VARCHAR(310)
                                                              , IN `v_vCampo13_detalle` VARCHAR(320)
                                                              , IN `v_vCampo14_detalle` VARCHAR(330)
                                                              , IN `v_vCampo15_detalle` VARCHAR(340)
                                                              , IN `v_vCampo16_detalle` VARCHAR(350)
                                                              , IN `v_vCampo17_detalle` VARCHAR(360)
                                                              , IN `v_vCampo18_detalle` VARCHAR(370)
                                                              , IN `v_vCampo19_detalle` VARCHAR(380)
                                                              , IN `v_vCampo20_detalle` VARCHAR(390)
                                                              , IN `v_vCampo21_detalle` VARCHAR(400)
                                                              , IN `v_vCampo22_detalle` VARCHAR(410)
                                                              , IN `v_vCampo23_detalle` VARCHAR(420)
                                                              , IN `v_vCampo24_detalle` VARCHAR(430)
                                                              , IN `v_vCampo25_detalle` VARCHAR(440)
                                                              , IN `v_vCampo26_detalle` VARCHAR(450)
                                                              , IN `v_vCampo27_detalle` VARCHAR(460)
                                                              , IN `v_vCampo28_detalle` VARCHAR(470)
                                                              , IN `v_vCampo29_detalle` VARCHAR(480)
                                                              , IN `v_vCampo30_detalle` VARCHAR(490)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE detalle 
                  SET vCampo1_detalle   = v_vCampo1_detalle
                    , vCampo2_detalle   = v_vCampo2_detalle
                    , vCampo3_detalle   = v_vCampo3_detalle
                    , vCampo4_detalle   = v_vCampo4_detalle
                    , vCampo5_detalle   = v_vCampo5_detalle
                    , vCampo6_detalle   = v_vCampo6_detalle
                    , vCampo7_detalle   = v_vCampo7_detalle
                    , vCampo8_detalle   = v_vCampo8_detalle
                    , vCampo9_detalle   = v_vCampo9_detalle
                    , vCampo10_detalle   = v_vCampo10_detalle
                    , vCampo11_detalle   = v_vCampo11_detalle
                    , vCampo12_detalle   = v_vCampo12_detalle
                    , vCampo13_detalle   = v_vCampo13_detalle
                    , vCampo14_detalle   = v_vCampo14_detalle
                    , vCampo15_detalle   = v_vCampo15_detalle
                    , vCampo16_detalle   = v_vCampo16_detalle
                    , vCampo17_detalle   = v_vCampo17_detalle
                    , vCampo18_detalle   = v_vCampo18_detalle
                    , vCampo19_detalle   = v_vCampo19_detalle
                    , vCampo20_detalle   = v_vCampo20_detalle
                    , vCampo21_detalle   = v_vCampo21_detalle
                    , vCampo22_detalle   = v_vCampo22_detalle
                    , vCampo23_detalle   = v_vCampo23_detalle
                    , vCampo24_detalle   = v_vCampo24_detalle
                    , vCampo25_detalle   = v_vCampo25_detalle
                    , vCampo26_detalle   = v_vCampo26_detalle
                    , vCampo27_detalle   = v_vCampo27_detalle
                    , vCampo28_detalle   = v_vCampo28_detalle
                    , vCampo29_detalle   = v_vCampo29_detalle
                    , vCampo30_detalle   = v_vCampo30_detalle
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_detalle');

    }
};
