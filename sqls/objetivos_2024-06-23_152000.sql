CREATE TABLE `objetivos` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_eda_colab` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicadores` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `porcentaje` decimal(5,2) NOT NULL,
  `autocalificacion` int NOT NULL DEFAULT '0',
  `promedio` int NOT NULL DEFAULT '0',
  `autocalificacion_2` int NOT NULL DEFAULT '0',
  `promedio_2` int NOT NULL DEFAULT '0',
  `editado` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;