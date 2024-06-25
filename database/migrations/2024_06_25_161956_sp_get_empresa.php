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
            CREATE PROCEDURE sp_get_empresa(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_user_id varchar(100)
                                                    , buscar_logo varchar(100)
                                                    , buscar_nombre varchar(100)
                                                    , buscar_descripcion varchar(100)
                                                    , buscar_telefono varchar(100)
                                                    , buscar_whatsapp varchar(100)
                                                    , buscar_ubicacion varchar(100)
                                                    , buscar_longitud varchar(100)
                                                    , buscar_latitud varchar(100)
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
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY user_id ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY logo ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY nombre ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY descripcion ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY telefono ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY whatsapp ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY ubicacion ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY longitud ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY latitud ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , user_id
                                            , logo
                                            , nombre
                                            , descripcion
                                            , telefono
                                            , whatsapp
                                            , ubicacion
                                            , longitud
                                            , latitud
                                        FROM empresa 
                                        WHERE empresa.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  logo LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  nombre LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  descripcion LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  telefono LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  whatsapp LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  ubicacion LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  longitud LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  latitud LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(buscar_user_id),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  logo LIKE \'%",TRIM(buscar_logo),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  nombre LIKE \'%",TRIM(buscar_nombre),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  descripcion LIKE \'%",TRIM(buscar_descripcion),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  telefono LIKE \'%",TRIM(buscar_telefono),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  whatsapp LIKE \'%",TRIM(buscar_whatsapp),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  ubicacion LIKE \'%",TRIM(buscar_ubicacion),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  longitud LIKE \'%",TRIM(buscar_longitud),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  latitud LIKE \'%",TRIM(buscar_latitud),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM empresa WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_empresa');

    }
};
