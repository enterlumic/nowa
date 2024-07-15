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
            CREATE PROCEDURE sp_get_empleados(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_nombre varchar(100)
                                                    , buscar_direccion varchar(100)
                                                    , buscar_telefono varchar(100)
                                                    , buscar_email varchar(100)
                                                    , buscar_fecha_ingreso varchar(100)
                                                    , buscar_puesto varchar(100)
                                                    , buscar_salario varchar(100)
                                                    , buscar_jornada varchar(100)
                                                    , buscar_especialidades varchar(100)
                                                    , buscar_certificaciones varchar(100)
                                                    , i_limit_init int
                                                    , i_limit_end int
                                                    , i_colum_order int
                                                    , vc_order_direct varchar(20)
                                                    , OUT v_registro_total BIGINT(20)
                                                  )
            BEGIN
                DECLARE vc_column_order VARCHAR(100);

                SET vc_column_order=CASE 
                                    WHEN i_colum_order=0 THEN CONCAT(" ORDER BY id ",vc_order_direct)
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY nombre ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY direccion ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY telefono ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY email ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY fecha_ingreso ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY puesto ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY salario ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY jornada ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY especialidades ",vc_order_direct)
                                    WHEN i_colum_order=10 THEN CONCAT(" ORDER BY certificaciones ",vc_order_direct)
                                    WHEN i_colum_order=11 THEN CONCAT(" ORDER BY usuario ",vc_order_direct)
                                    WHEN i_colum_order=12 THEN CONCAT(" ORDER BY contrasenia ",vc_order_direct)
                                    WHEN i_colum_order=13 THEN CONCAT(" ORDER BY estado ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , nombre
                                            , direccion
                                            , telefono
                                            , email
                                            , fecha_ingreso
                                            , puesto
                                            , salario
                                            , jornada
                                            , especialidades
                                            , certificaciones
                                            , usuario
                                            , contrasenia
                                            , estado
                                        FROM empleados 
                                        WHERE empleados.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (nombre LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  direccion LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  telefono LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  email LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  fecha_ingreso LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  puesto LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  salario LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  jornada LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  especialidades LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  certificaciones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  usuario LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  contrasenia LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  estado LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (nombre LIKE \'%",TRIM(buscar_nombre),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  direccion LIKE \'%",TRIM(buscar_direccion),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  telefono LIKE \'%",TRIM(buscar_telefono),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  email LIKE \'%",TRIM(buscar_email),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  fecha_ingreso LIKE \'%",TRIM(buscar_fecha_ingreso),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  puesto LIKE \'%",TRIM(buscar_puesto),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  salario LIKE \'%",TRIM(buscar_salario),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  jornada LIKE \'%",TRIM(buscar_jornada),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  especialidades LIKE \'%",TRIM(buscar_especialidades),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  certificaciones LIKE \'%",TRIM(buscar_certificaciones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM empleados WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_empleados');

    }
};
