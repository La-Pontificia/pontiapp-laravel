CREATE TABLE `feedbacks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_emisor` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `calificacion` int DEFAULT '3',
  `recibido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_recibido` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;