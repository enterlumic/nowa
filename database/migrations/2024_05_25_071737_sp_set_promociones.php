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
            CREATE PROCEDURE sp_set_promociones(IN `v_id` BIGINT(20)
                                                              , IN `v_vCampo1_promociones` VARCHAR(200)
                                                              , IN `v_vCampo2_promociones` VARCHAR(210)
                                                              , IN `v_vCampo3_promociones` VARCHAR(220)
                                                              , IN `v_vCampo4_promociones` VARCHAR(230)
                                                              , IN `v_vCampo5_promociones` VARCHAR(240)
                                                              , IN `v_vCampo6_promociones` VARCHAR(250)
                                                              , IN `v_vCampo7_promociones` VARCHAR(260)
                                                              , IN `v_vCampo8_promociones` VARCHAR(270)
                                                              , IN `v_vCampo9_promociones` VARCHAR(280)
                                                              , IN `v_vCampo10_promociones` VARCHAR(290)
                                                              , IN `v_vCampo11_promociones` VARCHAR(300)
                                                              , IN `v_vCampo12_promociones` VARCHAR(310)
                                                              , IN `v_vCampo13_promociones` VARCHAR(320)
                                                              , IN `v_vCampo14_promociones` VARCHAR(330)
                                                              , IN `v_vCampo15_promociones` VARCHAR(340)
                                                              , IN `v_vCampo16_promociones` VARCHAR(350)
                                                              , IN `v_vCampo17_promociones` VARCHAR(360)
                                                              , IN `v_vCampo18_promociones` VARCHAR(370)
                                                              , IN `v_vCampo19_promociones` VARCHAR(380)
                                                              , IN `v_vCampo20_promociones` VARCHAR(390)
                                                              , IN `v_vCampo21_promociones` VARCHAR(400)
                                                              , IN `v_vCampo22_promociones` VARCHAR(410)
                                                              , IN `v_vCampo23_promociones` VARCHAR(420)
                                                              , IN `v_vCampo24_promociones` VARCHAR(430)
                                                              , IN `v_vCampo25_promociones` VARCHAR(440)
                                                              , IN `v_vCampo26_promociones` VARCHAR(450)
                                                              , IN `v_vCampo27_promociones` VARCHAR(460)
                                                              , IN `v_vCampo28_promociones` VARCHAR(470)
                                                              , IN `v_vCampo29_promociones` VARCHAR(480)
                                                              , IN `v_vCampo30_promociones` VARCHAR(490)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE promociones 
                  SET vCampo1_promociones   = v_vCampo1_promociones
                    , vCampo2_promociones   = v_vCampo2_promociones
                    , vCampo3_promociones   = v_vCampo3_promociones
                    , vCampo4_promociones   = v_vCampo4_promociones
                    , vCampo5_promociones   = v_vCampo5_promociones
                    , vCampo6_promociones   = v_vCampo6_promociones
                    , vCampo7_promociones   = v_vCampo7_promociones
                    , vCampo8_promociones   = v_vCampo8_promociones
                    , vCampo9_promociones   = v_vCampo9_promociones
                    , vCampo10_promociones   = v_vCampo10_promociones
                    , vCampo11_promociones   = v_vCampo11_promociones
                    , vCampo12_promociones   = v_vCampo12_promociones
                    , vCampo13_promociones   = v_vCampo13_promociones
                    , vCampo14_promociones   = v_vCampo14_promociones
                    , vCampo15_promociones   = v_vCampo15_promociones
                    , vCampo16_promociones   = v_vCampo16_promociones
                    , vCampo17_promociones   = v_vCampo17_promociones
                    , vCampo18_promociones   = v_vCampo18_promociones
                    , vCampo19_promociones   = v_vCampo19_promociones
                    , vCampo20_promociones   = v_vCampo20_promociones
                    , vCampo21_promociones   = v_vCampo21_promociones
                    , vCampo22_promociones   = v_vCampo22_promociones
                    , vCampo23_promociones   = v_vCampo23_promociones
                    , vCampo24_promociones   = v_vCampo24_promociones
                    , vCampo25_promociones   = v_vCampo25_promociones
                    , vCampo26_promociones   = v_vCampo26_promociones
                    , vCampo27_promociones   = v_vCampo27_promociones
                    , vCampo28_promociones   = v_vCampo28_promociones
                    , vCampo29_promociones   = v_vCampo29_promociones
                    , vCampo30_promociones   = v_vCampo30_promociones
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_promociones');

    }
};
