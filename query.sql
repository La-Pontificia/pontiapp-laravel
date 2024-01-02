-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: eda_consorcio
-- ------------------------------------------------------
-- Server version	8.1.0
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!50503 SET NAMES utf8 */
;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;

/*!40103 SET TIME_ZONE='+00:00' */
;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

--
-- Dumping data for table `accesos`
--
LOCK TABLES `accesos` WRITE;

/*!40000 ALTER TABLE `accesos` DISABLE KEYS */
;

INSERT INTO
    `accesos`
VALUES
    (
        11,
        'colaboradores',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        12,
        'accesos',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        13,
        'edas',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        14,
        'areas',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        15,
        'departamentos',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        16,
        'cargos',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        17,
        'puestos',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        18,
        'sedes',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        19,
        'reportes',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    ),
    (
        20,
        'objetivos',
        1,
        1,
        1,
        1,
        3,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    );

/*!40000 ALTER TABLE `accesos` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `areas`
--
LOCK TABLES `areas` WRITE;

/*!40000 ALTER TABLE `areas` DISABLE KEYS */
;

INSERT INTO
    `areas`
VALUES
    (1, 'A001', 'Administrativo', NULL, NULL);

/*!40000 ALTER TABLE `areas` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `auditoria`
--
LOCK TABLES `auditoria` WRITE;

/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */
;

/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `cargos`
--
LOCK TABLES `cargos` WRITE;

/*!40000 ALTER TABLE `cargos` DISABLE KEYS */
;

INSERT INTO
    `cargos`
VALUES
    (
        1,
        'C001',
        'Director Administrativo',
        1,
        1,
        NULL,
        NULL
    );

/*!40000 ALTER TABLE `cargos` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `colaboradores`
--
LOCK TABLES `colaboradores` WRITE;

/*!40000 ALTER TABLE `colaboradores` DISABLE KEYS */
;

INSERT INTO
    `colaboradores`
VALUES
    (
        3,
        '00000000',
        'DEV',
        'Developer',
        NULL,
        NULL,
        2,
        1,
        1,
        1,
        NULL,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    );

/*!40000 ALTER TABLE `colaboradores` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `cuestionario_pregunta`
--
LOCK TABLES `cuestionario_pregunta` WRITE;

/*!40000 ALTER TABLE `cuestionario_pregunta` DISABLE KEYS */
;

/*!40000 ALTER TABLE `cuestionario_pregunta` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `cuestionarios`
--
LOCK TABLES `cuestionarios` WRITE;

/*!40000 ALTER TABLE `cuestionarios` DISABLE KEYS */
;

/*!40000 ALTER TABLE `cuestionarios` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `departamentos`
--
LOCK TABLES `departamentos` WRITE;

/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */
;

INSERT INTO
    `departamentos`
VALUES
    (1, 'D001', 'Administrativo', 1, NULL, NULL);

/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `eda_colabs`
--
LOCK TABLES `eda_colabs` WRITE;

/*!40000 ALTER TABLE `eda_colabs` DISABLE KEYS */
;

/*!40000 ALTER TABLE `eda_colabs` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `edas`
--
LOCK TABLES `edas` WRITE;

/*!40000 ALTER TABLE `edas` DISABLE KEYS */
;

INSERT INTO
    `edas`
VALUES
    (
        1,
        2023,
        1,
        '2024-01-03 04:03:43',
        '2024-01-03 04:03:43'
    );

/*!40000 ALTER TABLE `edas` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `evaluaciones`
--
LOCK TABLES `evaluaciones` WRITE;

/*!40000 ALTER TABLE `evaluaciones` DISABLE KEYS */
;

/*!40000 ALTER TABLE `evaluaciones` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--
LOCK TABLES `failed_jobs` WRITE;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */
;

/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `feedbacks`
--
LOCK TABLES `feedbacks` WRITE;

/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */
;

/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `media`
--
LOCK TABLES `media` WRITE;

/*!40000 ALTER TABLE `media` DISABLE KEYS */
;

/*!40000 ALTER TABLE `media` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--
LOCK TABLES `migrations` WRITE;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */
;

INSERT INTO
    `migrations`
VALUES
    (
        1,
        '2014_10_12_100000_create_password_reset_tokens_table',
        1
    ),
    (
        2,
        '2014_10_12_100000_create_password_resets_table',
        1
    ),
    (
        3,
        '2019_08_19_000000_create_failed_jobs_table',
        1
    ),
    (
        4,
        '2019_12_14_000001_create_personal_access_tokens_table',
        1
    ),
    (5, '2020_06_14_000001_create_media_table', 1),
    (6, '2023_08_09_031813_create_edas_table', 1),
    (7, '2023_08_09_193109_create_evaluaciones', 1),
    (8, '2023_08_10_031629_create_sedes', 1),
    (9, '2023_08_23_152448_create_areas_table', 1),
    (
        10,
        '2023_08_24_152503_create_departamentos_table',
        1
    ),
    (11, '2023_08_24_152509_create_puestos_table', 1),
    (12, '2023_08_25_152456_create_cargos_table', 1),
    (
        13,
        '2023_08_25_152523_create_colaboradores_table',
        1
    ),
    (14, '2023_08_25_163913_create_accesos_table', 1),
    (15, '2023_10_02_171137_create_cuestionarios', 1),
    (
        16,
        '2023_10_03_031829_create_eda_colabs_table',
        1
    ),
    (
        17,
        '2023_10_03_031936_create_feedbacks_table',
        1
    ),
    (
        18,
        '2023_10_04_221122_create_objetivos_table',
        1
    ),
    (19, '2023_11_14_170503_create_preguntas', 1),
    (20, '2023_11_14_170650_create_plantillas', 1),
    (
        21,
        '2023_11_14_171033_create_plantilla_pregunta',
        1
    ),
    (
        22,
        '2023_11_14_171653_create_cuestionario_pregunta',
        1
    ),
    (23, '2023_11_26_223605_create_auditoria', 1),
    (24, '2023_12_29_000000_create_users_table', 1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `objetivos`
--
LOCK TABLES `objetivos` WRITE;

/*!40000 ALTER TABLE `objetivos` DISABLE KEYS */
;

/*!40000 ALTER TABLE `objetivos` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `password_reset_tokens`
--
LOCK TABLES `password_reset_tokens` WRITE;

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */
;

/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--
LOCK TABLES `password_resets` WRITE;

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */
;

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `personal_access_tokens`
--
LOCK TABLES `personal_access_tokens` WRITE;

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */
;

/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `plantilla_pregunta`
--
LOCK TABLES `plantilla_pregunta` WRITE;

/*!40000 ALTER TABLE `plantilla_pregunta` DISABLE KEYS */
;

/*!40000 ALTER TABLE `plantilla_pregunta` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `plantillas`
--
LOCK TABLES `plantillas` WRITE;

/*!40000 ALTER TABLE `plantillas` DISABLE KEYS */
;

/*!40000 ALTER TABLE `plantillas` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `preguntas`
--
LOCK TABLES `preguntas` WRITE;

/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */
;

/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `puestos`
--
LOCK TABLES `puestos` WRITE;

/*!40000 ALTER TABLE `puestos` DISABLE KEYS */
;

INSERT INTO
    `puestos`
VALUES
    (1, 'P001', 'Director', NULL, NULL),
    (2, 'P002', 'Asesor', NULL, NULL);

/*!40000 ALTER TABLE `puestos` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `sedes`
--
LOCK TABLES `sedes` WRITE;

/*!40000 ALTER TABLE `sedes` DISABLE KEYS */
;

INSERT INTO
    `sedes`
VALUES
    (1, 'Alameda', '', NULL, NULL);

/*!40000 ALTER TABLE `sedes` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */
;

INSERT INTO
    `users`
VALUES
    (
        3,
        'Developer',
        '00000000',
        3,
        NULL,
        '$2y$10$84jG7KS6Qm75ZqfojudaU.G.r8DrL8jOoHQzVXNkkKlyt54q2njsG',
        NULL,
        '2024-01-03 04:47:06',
        '2024-01-03 04:47:06'
    );

/*!40000 ALTER TABLE `users` ENABLE KEYS */
;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;

-- Dump completed on 2024-01-02 18:50:19