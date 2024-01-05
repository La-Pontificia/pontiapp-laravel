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
-- Dumping data for table `areas`
--
LOCK TABLES `areas` WRITE;

/*!40000 ALTER TABLE `areas` DISABLE KEYS */
;

INSERT INTO
    `areas`
VALUES
    (
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        'A001',
        'Dev',
        NULL,
        NULL
    );

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
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        'C001',
        'Dev',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
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
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        'ADMIN',
        '[\"eliminar_eda\", \"mantenimiento\", \"reportes\", \"auditoria\"]',
        'User',
        'Developer',
        '72377685@elp.edu.pe',
        NULL,
        2,
        1,
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        NULL,
        NULL,
        '2024-01-04 22:56:45'
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

INSERT INTO
    `cuestionario_pregunta`
VALUES
    (
        '9b03ac08-9d46-4c9a-95d2-1460fa3bc011',
        '9b03ac08-9410-4377-b275-f2cc5bbcef45',
        '9b03a8f2-d2f4-411a-a19e-4945af177b18',
        'wgwrgwg',
        '2024-01-05 01:38:54',
        '2024-01-05 01:38:54'
    ),
    (
        '9b03ac12-63bd-4e07-aec4-389e3a69f8d3',
        '9b03ac12-6142-4399-a7cb-6967d0097cd6',
        '9b03a8ff-e6f2-40bc-afff-c9877012a4d6',
        'nyjrjryj',
        '2024-01-05 01:39:00',
        '2024-01-05 01:39:00'
    );

/*!40000 ALTER TABLE `cuestionario_pregunta` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `cuestionarios`
--
LOCK TABLES `cuestionarios` WRITE;

/*!40000 ALTER TABLE `cuestionarios` DISABLE KEYS */
;

INSERT INTO
    `cuestionarios`
VALUES
    (
        '9b03ac08-9410-4377-b275-f2cc5bbcef45',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        '2024-01-05 01:38:54',
        '2024-01-05 01:38:54'
    ),
    (
        '9b03ac12-6142-4399-a7cb-6967d0097cd6',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        '2024-01-05 01:39:00',
        '2024-01-05 01:39:00'
    );

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
    (
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        'D001',
        'Dev',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        NULL,
        NULL
    );

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
        '9b03ae8c-d0f8-4c26-9b2d-197fe7afbbf9',
        2024,
        0,
        '2024-01-05 01:45:56',
        '2024-01-05 01:45:56'
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
-- Dumping data for table `feedbacks`
--
LOCK TABLES `feedbacks` WRITE;

/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */
;

/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */
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
-- Dumping data for table `plantilla_pregunta`
--
LOCK TABLES `plantilla_pregunta` WRITE;

/*!40000 ALTER TABLE `plantilla_pregunta` DISABLE KEYS */
;

INSERT INTO
    `plantilla_pregunta`
VALUES
    (
        '9b03a90f-6324-4f7c-a3f0-046574cbb602',
        '9b03a90f-5c24-4c55-a6ab-fa8da69efac8',
        '9b03a8ff-e6f2-40bc-afff-c9877012a4d6',
        '2024-01-05 01:30:35',
        '2024-01-05 01:30:35'
    ),
    (
        '9b03a922-75b2-4977-bd48-3a1da2d74f4e',
        '9b03a922-7320-4d70-9ecf-9748d5e13173',
        '9b03a8f2-d2f4-411a-a19e-4945af177b18',
        '2024-01-05 01:30:48',
        '2024-01-05 01:30:48'
    );

/*!40000 ALTER TABLE `plantilla_pregunta` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `plantillas`
--
LOCK TABLES `plantillas` WRITE;

/*!40000 ALTER TABLE `plantillas` DISABLE KEYS */
;

INSERT INTO
    `plantillas`
VALUES
    (
        '9b03a90f-5c24-4c55-a6ab-fa8da69efac8',
        'Plantilla 1',
        1,
        'supervisores',
        '2024-01-05 01:30:35',
        '2024-01-05 01:34:17'
    ),
    (
        '9b03a922-7320-4d70-9ecf-9748d5e13173',
        'Plantilla',
        1,
        'colaboradores',
        '2024-01-05 01:30:48',
        '2024-01-05 01:35:35'
    );

/*!40000 ALTER TABLE `plantillas` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping data for table `preguntas`
--
LOCK TABLES `preguntas` WRITE;

/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */
;

INSERT INTO
    `preguntas`
VALUES
    (
        '9b03a8f2-d2f4-411a-a19e-4945af177b18',
        'Pregunta para un colaborador',
        '2024-01-05 01:30:16',
        '2024-01-05 01:30:16'
    ),
    (
        '9b03a8ff-e6f2-40bc-afff-c9877012a4d6',
        'Pregunta para un supervisor',
        '2024-01-05 01:30:25',
        '2024-01-05 01:30:25'
    );

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
    (
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        0,
        'P001',
        'Dev',
        NULL,
        NULL
    );

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
    (
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        'Alameda',
        NULL,
        NULL,
        NULL
    );

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
        1,
        'Dev',
        'ADMIN',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        NULL,
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        '7565141d-67b0-45f9-be3d-f4ebc9347bd4',
        NULL,
        NULL
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

-- Dump completed on 2024-01-04 15:48:06