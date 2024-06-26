CREATE TABLE `cuestionario_pregunta` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cuestionario` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pregunta` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;