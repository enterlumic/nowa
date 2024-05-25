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
            CREATE PROCEDURE sp_get_promociones(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_vCampo1_promociones varchar(100)
                                                    , buscar_vCampo2_promociones varchar(100)
                                                    , buscar_vCampo3_promociones varchar(100)
                                                    , buscar_vCampo4_promociones varchar(100)
                                                    , buscar_vCampo5_promociones varchar(100)
                                                    , buscar_vCampo6_promociones varchar(100)
                                                    , buscar_vCampo7_promociones varchar(100)
                                                    , buscar_vCampo8_promociones varchar(100)
                                                    , buscar_vCampo9_promociones varchar(100)
                                                    , buscar_vCampo10_promociones varchar(100)
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
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY vCampo1_promociones ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY vCampo2_promociones ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY vCampo3_promociones ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY vCampo4_promociones ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY vCampo5_promociones ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY vCampo6_promociones ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY vCampo7_promociones ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY vCampo8_promociones ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY vCampo9_promociones ",vc_order_direct)
                                    WHEN i_colum_order=10 THEN CONCAT(" ORDER BY vCampo10_promociones ",vc_order_direct)
                                    WHEN i_colum_order=11 THEN CONCAT(" ORDER BY vCampo11_promociones ",vc_order_direct)
                                    WHEN i_colum_order=12 THEN CONCAT(" ORDER BY vCampo12_promociones ",vc_order_direct)
                                    WHEN i_colum_order=13 THEN CONCAT(" ORDER BY vCampo13_promociones ",vc_order_direct)
                                    WHEN i_colum_order=14 THEN CONCAT(" ORDER BY vCampo14_promociones ",vc_order_direct)
                                    WHEN i_colum_order=15 THEN CONCAT(" ORDER BY vCampo15_promociones ",vc_order_direct)
                                    WHEN i_colum_order=16 THEN CONCAT(" ORDER BY vCampo16_promociones ",vc_order_direct)
                                    WHEN i_colum_order=17 THEN CONCAT(" ORDER BY vCampo17_promociones ",vc_order_direct)
                                    WHEN i_colum_order=18 THEN CONCAT(" ORDER BY vCampo18_promociones ",vc_order_direct)
                                    WHEN i_colum_order=19 THEN CONCAT(" ORDER BY vCampo19_promociones ",vc_order_direct)
                                    WHEN i_colum_order=20 THEN CONCAT(" ORDER BY vCampo20_promociones ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , vCampo1_promociones
                                            , vCampo2_promociones
                                            , vCampo3_promociones
                                            , vCampo4_promociones
                                            , vCampo5_promociones
                                            , vCampo6_promociones
                                            , vCampo7_promociones
                                            , vCampo8_promociones
                                            , vCampo9_promociones
                                            , vCampo10_promociones
                                            , vCampo11_promociones
                                            , vCampo12_promociones
                                            , vCampo13_promociones
                                            , vCampo14_promociones
                                            , vCampo15_promociones
                                            , vCampo16_promociones
                                            , vCampo17_promociones
                                            , vCampo18_promociones
                                            , vCampo19_promociones
                                            , vCampo20_promociones
                                        FROM promociones 
                                        WHERE promociones.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo2_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo3_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo4_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo5_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo6_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo7_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo8_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo9_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo10_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo11_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo12_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo13_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo14_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo15_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo16_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo17_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo18_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo19_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo20_promociones LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_promociones LIKE \'%",TRIM(buscar_vCampo1_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo2_promociones LIKE \'%",TRIM(buscar_vCampo2_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo3_promociones LIKE \'%",TRIM(buscar_vCampo3_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo4_promociones LIKE \'%",TRIM(buscar_vCampo4_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo5_promociones LIKE \'%",TRIM(buscar_vCampo5_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo6_promociones LIKE \'%",TRIM(buscar_vCampo6_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo7_promociones LIKE \'%",TRIM(buscar_vCampo7_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo8_promociones LIKE \'%",TRIM(buscar_vCampo8_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo9_promociones LIKE \'%",TRIM(buscar_vCampo9_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo10_promociones LIKE \'%",TRIM(buscar_vCampo10_promociones),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM promociones WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_promociones');

    }
};
