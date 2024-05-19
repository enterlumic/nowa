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
            CREATE PROCEDURE sp_get_cliente_conekta(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_name varchar(100)
                                                    , buscar_email varchar(100)
                                                    , buscar_phone varchar(100)
                                                    , buscar_token_id varchar(100)
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
                                    WHEN i_colum_order=1 THEN CONCAT(" ORDER BY name ",vc_order_direct)
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY email ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY phone ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY token_id ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , name
                                            , email
                                            , phone
                                            , token_id
                                        FROM cliente_conekta 
                                        WHERE cliente_conekta.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (name LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  email LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  phone LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  token_id LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (name LIKE \'%",TRIM(buscar_name),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  email LIKE \'%",TRIM(buscar_email),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  phone LIKE \'%",TRIM(buscar_phone),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  token_id LIKE \'%",TRIM(buscar_token_id),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM cliente_conekta WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_cliente_conekta');

    }
};
