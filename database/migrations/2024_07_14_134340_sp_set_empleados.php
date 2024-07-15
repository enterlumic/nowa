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
            CREATE PROCEDURE sp_set_empleados(IN `v_id` BIGINT(20)
                                                              , IN `v_nombre` VARCHAR(200)
                                                              , IN `v_direccion` VARCHAR(210)
                                                              , IN `v_telefono` VARCHAR(220)
                                                              , IN `v_email` VARCHAR(230)
                                                              , IN `v_fecha_ingreso` VARCHAR(240)
                                                              , IN `v_puesto` VARCHAR(250)
                                                              , IN `v_salario` VARCHAR(260)
                                                              , IN `v_jornada` VARCHAR(270)
                                                              , IN `v_especialidades` VARCHAR(280)
                                                              , IN `v_certificaciones` VARCHAR(290)
                                                              , IN `v_usuario` VARCHAR(300)
                                                              , IN `v_contrasenia` VARCHAR(310)
                                                              , IN `v_estado` VARCHAR(320)
                                                              , OUT `v_i_response` INTEGER)
            BEGIN
                SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

                UPDATE empleados 
                  SET nombre   = v_nombre
                    , direccion   = v_direccion
                    , telefono   = v_telefono
                    , email   = v_email
                    , fecha_ingreso   = v_fecha_ingreso
                    , puesto   = v_puesto
                    , salario   = v_salario
                    , jornada   = v_jornada
                    , especialidades   = v_especialidades
                    , certificaciones   = v_certificaciones
                    , usuario   = v_usuario
                    , contrasenia   = v_contrasenia
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_set_update_empleados');

    }
};
