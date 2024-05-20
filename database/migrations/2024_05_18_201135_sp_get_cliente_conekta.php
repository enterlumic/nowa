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
                                                    , buscar_number varchar(100)
                                                    , buscar_cvc varchar(100)
                                                    , buscar_exp_month varchar(100)
                                                    , buscar_exp_year varchar(100)
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
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY number ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY cvc ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY exp_month ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY exp_year ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , name
                                            , number
                                            , cvc
                                            , exp_month
                                            , exp_year
                                        FROM cliente_conekta 
                                        WHERE cliente_conekta.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (name LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  number LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  cvc LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  exp_month LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  exp_year LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (name LIKE \'%",TRIM(buscar_name),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  number LIKE \'%",TRIM(buscar_number),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  cvc LIKE \'%",TRIM(buscar_cvc),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  exp_month LIKE \'%",TRIM(buscar_exp_month),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  exp_year LIKE \'%",TRIM(buscar_exp_year),"%\'");
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
