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
            CREATE PROCEDURE sp_get_logss(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_user_id varchar(100)
                                                    , buscar_event_type varchar(100)
                                                    , buscar_context varchar(100)
                                                    , buscar_event_data varchar(100)
                                                    , buscar_execution_time varchar(100)
                                                    , buscar_status varchar(100)
                                                    , buscar_severity varchar(100)
                                                    , buscar_source varchar(100)
                                                    , buscar_ip_address varchar(100)
                                                    , buscar_user_agent varchar(100)
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
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY event_type ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY context ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY event_data ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY execution_time ",vc_order_direct)
                                    WHEN i_colum_order=6 THEN CONCAT(" ORDER BY status ",vc_order_direct)
                                    WHEN i_colum_order=7 THEN CONCAT(" ORDER BY severity ",vc_order_direct)
                                    WHEN i_colum_order=8 THEN CONCAT(" ORDER BY source ",vc_order_direct)
                                    WHEN i_colum_order=9 THEN CONCAT(" ORDER BY ip_address ",vc_order_direct)
                                    WHEN i_colum_order=10 THEN CONCAT(" ORDER BY user_agent ",vc_order_direct)
                                    WHEN i_colum_order=11 THEN CONCAT(" ORDER BY description ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , user_id
                                            , event_type
                                            , context
                                            , event_data
                                            , execution_time
                                            , status
                                            , severity
                                            , source
                                            , ip_address
                                            , user_agent
                                            , description
                                        FROM logss 
                                        WHERE logss.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  event_type LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  context LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  event_data LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  execution_time LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  status LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  severity LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  source LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  ip_address LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  user_agent LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  description LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(buscar_user_id),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  event_type LIKE \'%",TRIM(buscar_event_type),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  context LIKE \'%",TRIM(buscar_context),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  event_data LIKE \'%",TRIM(buscar_event_data),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  execution_time LIKE \'%",TRIM(buscar_execution_time),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  status LIKE \'%",TRIM(buscar_status),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  severity LIKE \'%",TRIM(buscar_severity),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  source LIKE \'%",TRIM(buscar_source),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  ip_address LIKE \'%",TRIM(buscar_ip_address),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  user_agent LIKE \'%",TRIM(buscar_user_agent),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM logss WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_logss');

    }
};
