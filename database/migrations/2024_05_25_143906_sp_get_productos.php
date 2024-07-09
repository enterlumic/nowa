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
            CREATE PROCEDURE sp_get_productos(   b_filtro_like bool,
                                                    vc_string_filtro varchar(100),
                                                    buscar_titulo varchar(100),
                                                    buscar_descripcion varchar(100),
                                                    buscar_precio varchar(100),
                                                    buscar_marca varchar(100),
                                                    buscar_review varchar(100),
                                                    buscar_cantidad varchar(100),
                                                    buscar_color varchar(100),
                                                    buscar_precio_anterior varchar(100),
                                                    buscar_target varchar(100),
                                                    i_limit_init int,
                                                    i_limit_end int,
                                                    i_colum_order int,
                                                    vc_order_direct varchar(20),
                                                    OUT v_registro_total BIGINT(20)
                                                  )
            BEGIN
                DECLARE vc_column_order VARCHAR(100);

                SET vc_column_order = CASE 
                                        WHEN i_colum_order = 0 THEN CONCAT(" ORDER BY id ", vc_order_direct)
                                        WHEN i_colum_order = 1 THEN CONCAT(" ORDER BY titulo ", vc_order_direct)
                                        WHEN i_colum_order = 2 THEN CONCAT(" ORDER BY descripcion ", vc_order_direct)
                                        WHEN i_colum_order = 3 THEN CONCAT(" ORDER BY precio ", vc_order_direct)
                                        WHEN i_colum_order = 4 THEN CONCAT(" ORDER BY marca ", vc_order_direct)
                                        WHEN i_colum_order = 5 THEN CONCAT(" ORDER BY review ", vc_order_direct)
                                        WHEN i_colum_order = 6 THEN CONCAT(" ORDER BY cantidad ", vc_order_direct)
                                        WHEN i_colum_order = 7 THEN CONCAT(" ORDER BY color ", vc_order_direct)
                                        WHEN i_colum_order = 8 THEN CONCAT(" ORDER BY precio_anterior ", vc_order_direct)
                                        WHEN i_colum_order = 9 THEN CONCAT(" ORDER BY target ", vc_order_direct)
                                        ELSE ""
                                      END;

                SET @_QUERY = CONCAT("SELECT p.id, titulo, foto_url AS foto, descripcion, precio, marca, review, cantidad, color, precio_anterior, target
                                      FROM productos p
                                      LEFT OUTER JOIN productos_fotos pf ON pf.producto_id = p.id AND pf.size = \'small\' AND pf.`order` = 0
                                      WHERE p.b_status > 0 ");

                IF(b_filtro_like = true) THEN
                    SET @_QUERY = CONCAT(@_QUERY, " AND (titulo LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR descripcion LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR precio LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR marca LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR review LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR cantidad LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR color LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR precio_anterior LIKE \'%", TRIM(vc_string_filtro), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " OR target LIKE \'%", TRIM(vc_string_filtro), "%\')");
                END IF;

                IF(b_filtro_like = false) THEN
                    SET @_QUERY = CONCAT(@_QUERY, " AND (titulo LIKE \'%", TRIM(buscar_titulo), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND descripcion LIKE \'%", TRIM(buscar_descripcion), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND precio LIKE \'%", TRIM(buscar_precio), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND marca LIKE \'%", TRIM(buscar_marca), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND review LIKE \'%", TRIM(buscar_review), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND cantidad LIKE \'%", TRIM(buscar_cantidad), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND color LIKE \'%", TRIM(buscar_color), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND precio_anterior LIKE \'%", TRIM(buscar_precio_anterior), "%\'");
                    SET @_QUERY = CONCAT(@_QUERY, " AND target LIKE \'%", TRIM(buscar_target), "%\')");
                END IF;

                IF(i_colum_order IS NOT NULL) THEN
                    SET @_QUERY = CONCAT(@_QUERY, vc_column_order);
                END IF;

                IF(i_limit_init >= 0 AND i_limit_end > 0) THEN
                    SET @_QUERY = CONCAT(@_QUERY, " LIMIT ", i_limit_init, ",", i_limit_end);
                END IF;

                PREPARE QRY FROM @_QUERY;
                EXECUTE QRY;
                DEALLOCATE PREPARE QRY;

                SELECT COUNT(*) INTO v_registro_total FROM productos WHERE b_status > 0;
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
        Schema::connection('mysql')->getConnection()->statement('DROP PROCEDURE IF EXISTS sp_get_productos');

    }
};
