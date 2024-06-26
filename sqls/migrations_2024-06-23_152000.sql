CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;insert into `migrations` (`batch`, `id`, `migration`) values (1, 1, '2014_10_12_100000_create_password_reset_tokens_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 2, '2014_10_12_100000_create_password_resets_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 3, '2019_08_19_000000_create_failed_jobs_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 4, '2019_12_14_000001_create_personal_access_tokens_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 5, '2020_06_14_000001_create_media_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 6, '2023_08_09_031813_create_edas_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 7, '2023_08_09_193109_create_evaluaciones');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 8, '2023_08_10_031629_create_sedes');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 9, '2023_08_23_152448_create_areas_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 10, '2023_08_24_152503_create_departamentos_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 11, '2023_08_24_152509_create_puestos_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 12, '2023_08_25_152456_create_cargos_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 13, '2023_08_25_152523_create_colaboradores_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 14, '2023_10_02_031936_create_feedbacks_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 15, '2023_10_02_171137_create_cuestionarios');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 16, '2023_10_03_031829_create_eda_colabs_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 17, '2023_10_04_221122_create_objetivos_table');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 18, '2023_11_14_170503_create_preguntas');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 19, '2023_11_14_170650_create_plantillas');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 20, '2023_11_14_171033_create_plantilla_pregunta');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 21, '2023_11_14_171653_create_cuestionario_pregunta');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 22, '2023_11_26_223605_create_auditoria');
insert into `migrations` (`batch`, `id`, `migration`) values (1, 23, '2023_12_29_000000_create_users_table');
