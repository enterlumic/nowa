use nowa;


SELECT p.id, titulo, foto_url AS foto, descripcion, precio, marca, review, cantidad, color, precio_anterior, target
                                      FROM promociones p
                                      LEFT OUTER JOIN promocion_fotos pf ON pf.promocion_id = p.id AND pf.size = 'original'
                                      WHERE p.b_status > 0