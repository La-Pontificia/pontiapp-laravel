CREATE TABLE `evaluaciones` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promedio` int NOT NULL DEFAULT '0',
  `autocalificacion` int NOT NULL DEFAULT '0',
  `autocalificar` tinyint(1) NOT NULL DEFAULT '0',
  `calificar` tinyint(1) NOT NULL DEFAULT '0',
  `cerrado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_promedio` timestamp NULL DEFAULT NULL,
  `fecha_autocalificacion` timestamp NULL DEFAULT NULL,
  `fecha_cerrado` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;