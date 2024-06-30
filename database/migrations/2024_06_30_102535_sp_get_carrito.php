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
            CREATE PROCEDURE sp_get_carrito(   b_filtro_like bool
                                                    , vc_string_filtro varchar(100)
                                                    , buscar_user_id varchar(100)
                                                    , buscar_producto_id varchar(100)
                                                    , buscar_cantidad varchar(100)
                                                    , buscar_agregado_en varchar(100)
                                                    , buscar_estado varchar(100)
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
                                    WHEN i_colum_order=2 THEN CONCAT(" ORDER BY producto_id ",vc_order_direct)
                                    WHEN i_colum_order=3 THEN CONCAT(" ORDER BY cantidad ",vc_order_direct)
                                    WHEN i_colum_order=4 THEN CONCAT(" ORDER BY agregado_en ",vc_order_direct)
                                    WHEN i_colum_order=5 THEN CONCAT(" ORDER BY estado ",vc_order_direct)
                                    ELSE ""
                END;

                SET @_QUERY:=CONCAT("SELECT   id
                                            , user_id
                                            , producto_id
                                            , cantidad
                                            , agregado_en
                                            , estado
                                        FROM carrito 
                                        WHERE carrito.b_status > 0 "
                );

                IF(b_filtro_like=true) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  producto_id LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  cantidad LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  agregado_en LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " OR  estado LIKE \'%",TRIM(vc_string_filtro),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(b_filtro_like = false) THEN BEGIN

                    SET @_QUERY:=CONCAT(@_QUERY, " AND (user_id LIKE \'%",TRIM(buscar_user_id),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  producto_id LIKE \'%",TRIM(buscar_producto_id),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  cantidad LIKE \'%",TRIM(buscar_cantidad),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  agregado_en LIKE \'%",TRIM(buscar_agregado_en),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " AND  estado LIKE \'%",TRIM(buscar_estado),"%\'");
                    SET @_QUERY:=CONCAT(@_QUERY, " )");

                END; END IF;

                IF(i_colum_order IS NOT NULL) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
                END; END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                    SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
                END; END IF;

                PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

                SELECT COUNT(*) INTO v_registro_total FROM carrito WHERE b_status > 0;            

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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_carrito');

    }
};
