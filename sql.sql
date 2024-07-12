use nowa;
SELECT p.id, titulo, foto_url AS foto, descripcion, precio, marca, review, cantidad, color, precio_refaccion, target
                                      FROM productos p
                                       JOIN productos_fotos pf ON pf.producto_id = p.id AND pf.size = 'small' AND pf.`order` = 0
                                      WHERE p.b_status > 0 GROUP BY pf.size = 'small'

;

+----+-----------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------+-------+--------+----------+-------+-----------------+--------+
| id | titulo                                                                                                                                        | foto                                                     | descripcion                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | precio | marca | review | cantidad | color | precio_refaccion | target |
+----+-----------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------+-------+--------+----------+-------+-----------------+--------+
| 16 | sea brazil Pantalones Colombianos Levanta Pompa | Vaqueros de levantamiento de glúteos | Vaqueros de cintura alta para mujer | Vaqueros Lipo  | small_1720492502_0_Captura desde 2024-06-16 08-50-04.png | Obtén tus jeans de mezclilla de estilo colombiano hoy mismo en tu puerta. Luce increíble en cada momento de tu vida con los pantalones ajustados que tanto te gustan. Usa pantalones colombianos con la máxima confianza y seguridad de que tu cuerpo se verá fabuloso. Brilla donde quiera que vayas con tus nuevos jeans elásticos colombianos favoritos. Vive cada momento como si fuera especial con la comodidad y belleza del corte colombiano que tanto te gusta.      | 123    | 11    |        | 212      |       | 233             |        |
| 16 | sea brazil Pantalones Colombianos Levanta Pompa | Vaqueros de levantamiento de glúteos | Vaqueros de cintura alta para mujer | Vaqueros Lipo  | small_1720492503_1_Captura desde 2024-06-16 08-49-51.png | Obtén tus jeans de mezclilla de estilo colombiano hoy mismo en tu puerta. Luce increíble en cada momento de tu vida con los pantalones ajustados que tanto te gustan. Usa pantalones colombianos con la máxima confianza y seguridad de que tu cuerpo se verá fabuloso. Brilla donde quiera que vayas con tus nuevos jeans elásticos colombianos favoritos. Vive cada momento como si fuera especial con la comodidad y belleza del corte colombiano que tanto te gusta.      | 123    | 11    |        | 212      |       | 233             |        |
+----+-----------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------+-------+--------+----------+-------+-----------------+--------+
[Finished in 23ms]