CREATE TABLE `colaboradores` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `privilegios` json DEFAULT NULL,
  `apellidos` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_institucional` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perfil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/default-user.webp',
  `rol` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `id_cargo` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_sede` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_supervisor` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colaboradores_id_supervisor_index` (`id_supervisor`),
  CONSTRAINT `colaboradores_id_supervisor_foreign` FOREIGN KEY (`id_supervisor`) REFERENCES `colaboradores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;