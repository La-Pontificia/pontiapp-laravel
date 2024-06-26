CREATE TABLE `auditoria` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_colab` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;