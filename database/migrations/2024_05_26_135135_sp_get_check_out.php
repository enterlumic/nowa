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
            CREATE PROCEDURE sp_get_check_out(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_vCampo1_check_out varchar(100)
                                                    , buscar_vCampo2_check_out varchar(100)
                                                    , buscar_vCampo3_check_out varchar(100)
                                                    , buscar_vCampo4_check_out varchar(100)
                                                    , buscar_vCampo5_check_out varchar(100)
                                                    , buscar_vCampo6_check_out varchar(100)
                                                    , buscar_vCampo7_check_out varchar(100)
                                                    , buscar_vCampo8_check_out varchar(100)
                                                    , buscar_vCampo9_check_out varchar(100)
                                                    , buscar_vCampo10_check_out varchar(100)
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
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY vCampo1_check_out ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY vCampo2_check_out ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY vCampo3_check_out ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY vCampo4_check_out ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY vCampo5_check_out ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY vCampo6_check_out ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY vCampo7_check_out ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY vCampo8_check_out ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY vCampo9_check_out ",vc_order_direct)
                                    WHEN i_colum_order=10 THEN CONCAT(" ORDER BY vCampo10_check_out ",vc_order_direct)
                                    WHEN i_colum_order=11 THEN CONCAT(" ORDER BY vCampo11_check_out ",vc_order_direct)
                                    WHEN i_colum_order=12 THEN CONCAT(" ORDER BY vCampo12_check_out ",vc_order_direct)
                                    WHEN i_colum_order=13 THEN CONCAT(" ORDER BY vCampo13_check_out ",vc_order_direct)
                                    WHEN i_colum_order=14 THEN CONCAT(" ORDER BY vCampo14_check_out ",vc_order_direct)
                                    WHEN i_colum_order=15 THEN CONCAT(" ORDER BY vCampo15_check_out ",vc_order_direct)
                                    WHEN i_colum_order=16 THEN CONCAT(" ORDER BY vCampo16_check_out ",vc_order_direct)
                                    WHEN i_colum_order=17 THEN CONCAT(" ORDER BY vCampo17_check_out ",vc_order_direct)
                                    WHEN i_colum_order=18 THEN CONCAT(" ORDER BY vCampo18_check_out ",vc_order_direct)
                                    WHEN i_colum_order=19 THEN CONCAT(" ORDER BY vCampo19_check_out ",vc_order_direct)
                                    WHEN i_colum_order=20 THEN CONCAT(" ORDER BY vCampo20_check_out ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , vCampo1_check_out
                                            , vCampo2_check_out
                                            , vCampo3_check_out
                                            , vCampo4_check_out
                                            , vCampo5_check_out
                                            , vCampo6_check_out
                                            , vCampo7_check_out
                                            , vCampo8_check_out
                                            , vCampo9_check_out
                                            , vCampo10_check_out
                                            , vCampo11_check_out
                                            , vCampo12_check_out
                                            , vCampo13_check_out
                                            , vCampo14_check_out
                                            , vCampo15_check_out
                                            , vCampo16_check_out
                                            , vCampo17_check_out
                                            , vCampo18_check_out
                                            , vCampo19_check_out
                                            , vCampo20_check_out
                                        FROM check_out 
                                        WHERE check_out.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo2_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo3_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo4_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo5_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo6_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo7_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo8_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo9_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo10_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo11_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo12_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo13_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo14_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo15_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo16_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo17_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo18_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo19_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo20_check_out LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_check_out LIKE \'%",TRIM(buscar_vCampo1_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo2_check_out LIKE \'%",TRIM(buscar_vCampo2_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo3_check_out LIKE \'%",TRIM(buscar_vCampo3_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo4_check_out LIKE \'%",TRIM(buscar_vCampo4_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo5_check_out LIKE \'%",TRIM(buscar_vCampo5_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo6_check_out LIKE \'%",TRIM(buscar_vCampo6_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo7_check_out LIKE \'%",TRIM(buscar_vCampo7_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo8_check_out LIKE \'%",TRIM(buscar_vCampo8_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo9_check_out LIKE \'%",TRIM(buscar_vCampo9_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  vCampo10_check_out LIKE \'%",TRIM(buscar_vCampo10_check_out),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM check_out WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_check_out');

    }
};
