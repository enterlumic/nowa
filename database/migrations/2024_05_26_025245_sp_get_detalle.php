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
            CREATE PROCEDURE sp_get_detalle(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_vCampo1_detalle varchar(100)
                                                    , buscar_vCampo2_detalle varchar(100)
                                                    , buscar_vCampo3_detalle varchar(100)
                                                    , buscar_vCampo4_detalle varchar(100)
                                                    , buscar_vCampo5_detalle varchar(100)
                                                    , buscar_vCampo6_detalle varchar(100)
                                                    , buscar_vCampo7_detalle varchar(100)
                                                    , buscar_vCampo8_detalle varchar(100)
                                                    , buscar_vCampo9_detalle varchar(100)
                                                    , buscar_vCampo10_detalle varchar(100)
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
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY vCampo1_detalle ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY vCampo2_detalle ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY vCampo3_detalle ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY vCampo4_detalle ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY vCampo5_detalle ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY vCampo6_detalle ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY vCampo7_detalle ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY vCampo8_detalle ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY vCampo9_detalle ",vc_order_direct)
                                    WHEN i_colum_order=10 THEN CONCAT(" ORDER BY vCampo10_detalle ",vc_order_direct)
                                    WHEN i_colum_order=11 THEN CONCAT(" ORDER BY vCampo11_detalle ",vc_order_direct)
                                    WHEN i_colum_order=12 THEN CONCAT(" ORDER BY vCampo12_detalle ",vc_order_direct)
                                    WHEN i_colum_order=13 THEN CONCAT(" ORDER BY vCampo13_detalle ",vc_order_direct)
                                    WHEN i_colum_order=14 THEN CONCAT(" ORDER BY vCampo14_detalle ",vc_order_direct)
                                    WHEN i_colum_order=15 THEN CONCAT(" ORDER BY vCampo15_detalle ",vc_order_direct)
                                    WHEN i_colum_order=16 THEN CONCAT(" ORDER BY vCampo16_detalle ",vc_order_direct)
                                    WHEN i_colum_order=17 THEN CONCAT(" ORDER BY vCampo17_detalle ",vc_order_direct)
                                    WHEN i_colum_order=18 THEN CONCAT(" ORDER BY vCampo18_detalle ",vc_order_direct)
                                    WHEN i_colum_order=19 THEN CONCAT(" ORDER BY vCampo19_detalle ",vc_order_direct)
                                    WHEN i_colum_order=20 THEN CONCAT(" ORDER BY vCampo20_detalle ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , vCampo1_detalle
                                            , vCampo2_detalle
                                            , vCampo3_detalle
                                            , vCampo4_detalle
                                            , vCampo5_detalle
                                            , vCampo6_detalle
                                            , vCampo7_detalle
                                            , vCampo8_detalle
                                            , vCampo9_detalle
                                            , vCampo10_detalle
                                            , vCampo11_detalle
                                            , vCampo12_detalle
                                            , vCampo13_detalle
                                            , vCampo14_detalle
                                            , vCampo15_detalle
                                            , vCampo16_detalle
                                            , vCampo17_detalle
                                            , vCampo18_detalle
                                            , vCampo19_detalle
                                            , vCampo20_detalle
                                        FROM detalle 
                                        WHERE detalle.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo2_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo3_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo4_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo5_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo6_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo7_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo8_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo9_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo10_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo11_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo12_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo13_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo14_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo15_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo16_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo17_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo18_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo19_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo20_detalle LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_detalle LIKE \'%",TRIM(buscar_vCampo1_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo2_detalle LIKE \'%",TRIM(buscar_vCampo2_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo3_detalle LIKE \'%",TRIM(buscar_vCampo3_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo4_detalle LIKE \'%",TRIM(buscar_vCampo4_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo5_detalle LIKE \'%",TRIM(buscar_vCampo5_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo6_detalle LIKE \'%",TRIM(buscar_vCampo6_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo7_detalle LIKE \'%",TRIM(buscar_vCampo7_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo8_detalle LIKE \'%",TRIM(buscar_vCampo8_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo9_detalle LIKE \'%",TRIM(buscar_vCampo9_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo10_detalle LIKE \'%",TRIM(buscar_vCampo10_detalle),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM detalle WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_detalle');

    }
};
