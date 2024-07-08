use nowa;

-- drop table if exists carrito;

-- CREATE TABLE `carrito` (
--   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
--   `user_id` bigint(20) unsigned NOT NULL,
--   `producto_id` bigint(20) unsigned NOT NULL,
--   `cantidad` int(11) NOT NULL DEFAULT 1,
--   `agregado_en` timestamp NULL DEFAULT current_timestamp(),
--   `estado` enum('pendiente','comprado') NOT NULL DEFAULT 'pendiente',
--   PRIMARY KEY (`id`),
--   KEY `carrito_user_id_index` (`user_id`),
--   KEY `carrito_producto_id_index` (`producto_id`),
--   CONSTRAINT `carrito_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
--   CONSTRAINT `carrito_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


select `p`.`id`, `p`.`titulo`, `pf`.`foto_url`, `p`.`precio`, `p`.`marca` from `productos` as `p` inner join `productos_fotos` as `pf` on `pf`.`promocion_id` = `p`.`id` and `pf`.`size` = 'small' and `pf`.`order` = 0 where `p`.`b_status` > 0 and `p`.`id` = 16 order by `pf`.`order` asc