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
        1,
        'colaboradores',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        2,
        'accesos',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        3,
        'edas',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        4,
        'areas',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        5,
        'departamentos',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        6,
        'cargos',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        7,
        'puestos',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        8,
        'sedes',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        9,
        'reportes',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        10,
        'objetivos',
        1,
        1,
        1,
        1,
        1,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
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
    (
        1,
        'A001',
        'ACADÉMICA',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        2,
        'A002',
        'ADMINISTRATIVO',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        3,
        'A003',
        'CENTRO DE IDIOMAS',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        4,
        'A004',
        'CONTABILIDAD Y FINANZAS',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        5,
        'A005',
        'EDUCACIÓN CONTINUA ',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        6,
        'A006',
        'INVESTIGACIÓN E INNOVACIÓN',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        7,
        'A007',
        'MARKETING Y COMERCIAL',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        8,
        'A008',
        'SECRETARÍA GENERAL ',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        9,
        'A009',
        'SISTEMAS',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        10,
        'A010',
        'GESTIÓN DE PERSONAS',
        '2023-11-14 19:00:07',
        NULL
    );

/*!40000 ALTER TABLE `areas` ENABLE KEYS */
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
        'GERENTE GENERAL',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        2,
        'C002',
        'DIRECTOR',
        '2023-11-14 19:00:07',
        NULL
    ),
    (3, 'C003', 'JEFE', '2023-11-14 19:00:07', NULL),
    (
        4,
        'C004',
        'COORDINADOR',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        5,
        'C005',
        'ASISTENTE',
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        6,
        'C006',
        'ANALISTA',
        '2023-11-14 19:00:07',
        NULL
    ),
    (7, 'C007', 'ASESOR', '2023-11-14 19:00:07', NULL);

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
        1,
        '72377685',
        'BENDEZU ÑAHUI',
        'DAVID',
        '72377685@elp.edu.pe',
        NULL,
        2,
        1,
        58,
        1,
        NULL,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
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
    (
        1,
        'D001',
        'ACADÉMICA DE C. GESTIÓN...',
        1,
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        2,
        'D002',
        'ATENCIÓN AL ESTUDIANTE',
        2,
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        3,
        'D003',
        'CONTABILIDAD',
        4,
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        4,
        'D004',
        'BIENESTAR',
        2,
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        5,
        'D005',
        'SISTEMAS',
        9,
        '2023-11-14 19:00:07',
        NULL
    ),
    (
        6,
        'D006',
        'TALENTO HUMANO',
        10,
        '2023-11-14 19:00:07',
        NULL
    );

/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */
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
        2024,
        0,
        '2023-10-04 23:32:10',
        '2023-10-04 23:32:10'
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

INSERT INTO
    `evaluaciones`
VALUES
    (
        1,
        0,
        0,
        0,
        NULL,
        NULL,
        NULL,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    ),
    (
        2,
        0,
        0,
        0,
        NULL,
        NULL,
        NULL,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
    );

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

INSERT INTO
    `plantilla_pregunta`
VALUES
    (
        9,
        3,
        3,
        '2023-11-15 06:23:47',
        '2023-11-15 06:23:47'
    ),
    (
        10,
        3,
        5,
        '2023-11-15 06:23:47',
        '2023-11-15 06:23:47'
    ),
    (
        11,
        3,
        6,
        '2023-11-15 06:23:47',
        '2023-11-15 06:23:47'
    ),
    (
        12,
        3,
        8,
        '2023-11-15 06:23:47',
        '2023-11-15 06:23:47'
    ),
    (
        13,
        4,
        2,
        '2023-11-15 06:24:30',
        '2023-11-15 06:24:30'
    ),
    (
        14,
        4,
        5,
        '2023-11-15 06:24:30',
        '2023-11-15 06:24:30'
    ),
    (
        15,
        5,
        2,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        16,
        5,
        3,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        17,
        5,
        4,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        18,
        5,
        5,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        19,
        5,
        6,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        20,
        5,
        7,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
    ),
    (
        21,
        5,
        8,
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
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
        3,
        'Cuestionario 1',
        0,
        'supervisores',
        '2023-11-15 06:23:47',
        '2023-11-15 06:23:47'
    ),
    (
        4,
        'Cuestionario 2',
        0,
        'colaboradores',
        '2023-11-15 06:24:30',
        '2023-11-15 06:24:30'
    ),
    (
        5,
        'Cuestionario 2023',
        0,
        'supervisor',
        '2023-11-15 06:55:19',
        '2023-11-15 06:55:19'
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
        2,
        '¿Qué le aconsejas a tu colaborador que continúe mejorando?',
        '2023-11-15 01:24:54',
        '2023-11-15 01:24:54'
    ),
    (
        3,
        '¿Cuales son las fortalezas de tu colaborador?',
        '2023-11-15 01:24:59',
        '2023-11-15 01:24:59'
    ),
    (
        4,
        '¿Cuales son tus compromisos como líder para contribuir con el desempeño de tu colaborador?',
        '2023-11-15 01:25:04',
        '2023-11-15 01:25:04'
    ),
    (
        5,
        '¿Cuáles consideras que han sido tus principales logros (aquella tarea extra, actividad donde hayas logrado optimizar o reducir costos y tiempo, entre otras)?',
        '2023-11-15 01:25:09',
        '2023-11-15 01:25:09'
    ),
    (
        6,
        '¿En qué consideras que debes seguir trabajando?',
        '2023-11-15 01:25:13',
        '2023-11-15 01:25:13'
    ),
    (
        7,
        '¿Que le aconsejas a tu lider que deje de hacer?',
        '2023-11-15 01:25:24',
        '2023-11-15 01:25:24'
    ),
    (
        8,
        '¿Qué le aconsejas a tu líder que empiece hacer que hoy no está haciendo?',
        '2023-11-15 01:25:29',
        '2023-11-15 01:25:29'
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
        1,
        'P001',
        'COORDINADOR ACADÉMICO C. GESTIÓN Y TI',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        2,
        'P002',
        'JEFE ACADÉMICO C. GESTIÓN Y TI',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        3,
        'P003',
        'DIRECTOR ACADÉMICO',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        4,
        'P004',
        'JEFE ACADÉMICO C. SALUD',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        5,
        'P006',
        'DIRECTOR ADMINISTRATIVO',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        6,
        'P007',
        'DIRECTOR DE INVESTIGACIÓN E INNOVACIÓN ',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        7,
        'P008',
        'DIRECTOR GENERAL',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        8,
        'P009',
        'DIRECTORA DE GESTIÓN Y FINANZAS ',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        9,
        'P010',
        'DIRECTORA DE MARKETING Y COMERCIAL',
        2,
        2,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        10,
        'P011',
        'JEFE DE ADMISIÓN',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        11,
        'P012',
        'JEFE DE ADMISIÓN ELP',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        12,
        'P013',
        'JEFE DE COMUNICACIONES ',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        13,
        'P014',
        'JEFE DE GESTIÓN DE PERSONAS',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        14,
        'P015',
        'JEFE DE REGISTRO DE GRADOS Y TÍTULOS ',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        15,
        'P016',
        'JEFE DE SECRETARÍA ACADÉMICA  ',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        16,
        'P017',
        'JEFE DE SISTEMAS',
        3,
        3,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        17,
        'P018',
        'COORDINADOR ACADÉMICO C. SALUD',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        18,
        'P019',
        'COORDINADOR DE ATENCIÓN AL ESTUDIANTE',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        19,
        'P020',
        'COORDINADOR DE BIENESTAR ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        20,
        'P021',
        'COORDINADOR DE CALIDAD EDUCATIVA',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        21,
        'P022',
        'COORDINADOR DE CESTIFICACIONES',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        22,
        'P023',
        'COORDINADOR DE CLOUD, REDES Y CONECTIVIDAD  ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        23,
        'P024',
        'COORDINADOR DE COMUNICACIONES DE EC Y CI ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        24,
        'P025',
        'COORDINADOR DE COMUNICACIONES ELP ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        25,
        'P026',
        'COORDINADOR DE COMUNICACIONES ILP ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        26,
        'P027',
        'COORDINADOR DE CONTABILIDAD',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        27,
        'P028',
        'COORDINADOR DE EDUCACIÓN CONTINUA ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        28,
        'P029',
        'COORDINADOR DE EXPERIENCIA DEL ESTUDIANTE',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        29,
        'P030',
        'COORDINADOR DE RECAUDACIONES  ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        30,
        'P031',
        'COORDINADOR DE SECRETARÍA ACADÉMICA ILP',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        31,
        'P032',
        'COORDINADOR DE SERVICIOS Y DEMANDA',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        32,
        'P033',
        'COORDINADOR DE TALENTO ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        33,
        'P034',
        'COORDINADOR DE TESORERÍA ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        34,
        'P035',
        'COORDINADOR DEL CENTRO DE IDIOMAS ',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        35,
        'P036',
        'COORDINADOR DEL CENTRO DE INFORMACIÓN',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        36,
        'P037',
        'COORDINADOR DE INFRAESTRUCTURA',
        4,
        4,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        37,
        'P038',
        'ASESOR DE ADMISIÓN CI  ',
        7,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        38,
        'P039',
        'ASESOR DE ADMISIÓN EC  ',
        7,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        39,
        'P040',
        'ASESOR DE ADMISIÓN ELP ',
        7,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        40,
        'P041',
        'ASESOR DE ADMISIÓN ELP Y ILP  ',
        7,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        41,
        'P042',
        'ASESOR DE ADMISIÓN ILP ',
        7,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        42,
        'P043',
        'ASISTENTE ACADÉMICO C. GESTIÓN Y TI  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        43,
        'P044',
        'ASISTENTE ACADÉMICO C. SALUD  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        44,
        'P045',
        'ASISTENTE ADMINISTRATIVO ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        45,
        'P046',
        'ASISTENTE DE ATENCIÓN AL ESTUDIANTE  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        46,
        'P047',
        'ASISTENTE DE BIENESTAR ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        47,
        'P048',
        'ASISTENTE DE BOLSA DE TRABAJO ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        48,
        'P049',
        'ASISTENTE DE CERTIFICACIONES  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        49,
        'P050',
        'ASISTENTE DE COMUNICACIONES DE EC Y CI ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        50,
        'P051',
        'ASISTENTE DE CONTABILIDAD',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        51,
        'P052',
        'ASISTENTE DE DIRECCIÓN GENERAL',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        52,
        'P053',
        'ASISTENTE DE EXPERIENCIA DEL ESTUDIANTE',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        53,
        'P054',
        'ASISTENTE DE GRADOS Y TÍTULOS ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        54,
        'P055',
        'ASISTENTE DE INFRAESTRUCTURA  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        55,
        'P056',
        'ASISTENTE DE MENTORIA  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        56,
        'P057',
        'ASISTENTE DE RECAUDACIÓN ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        57,
        'P058',
        'ASISTENTE DE REDES SOCIALES',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        58,
        'P059',
        'ASISTENTE DE SISTEMAS  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        59,
        'P060',
        'ASISTENTE DE TESORERÍA ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        60,
        'P061',
        'ASISTENTE DE TÓPICO ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        61,
        'P062',
        'ASISTENTE DEL CENTRO DE INDORMACIÓN  ',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        62,
        'P063',
        'ASISTENTE SECRETARÍA ACADÉMICA ELP',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        63,
        'P064',
        'ASISTENTE SECRETARÍA ACADÉMICA ILP',
        5,
        5,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        64,
        'P065',
        'ANALISTA DE CALIDAD EDUCATIVA ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        65,
        'P066',
        'ANALISTA DE DISEÑO Y PRODUCCIÓN ILP  ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        66,
        'P067',
        'ANALISTA DE GESTIÓN DE PERSONAS ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        67,
        'P068',
        'ANALISTA DE MENTORIA',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        68,
        'P069',
        'ANALISTA DE MESA DE AYUDA',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        69,
        'P070',
        'ANALISTA DE TALENTO ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        70,
        'P071',
        'ANALISTA LEGAL  ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        71,
        'P072',
        'ANALISTA SECRETARIA ACADÉMICA ILP ',
        6,
        6,
        '2023-11-14 19:00:08',
        NULL
    ),
    (
        72,
        'P073',
        'ANALISTA SENIOR DE FINANZAS',
        6,
        6,
        '2023-11-14 19:00:08',
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
    (1, 'ALAMEDA', NULL, NULL, NULL),
    (2, 'JAZMINES', NULL, NULL, NULL),
    (3, 'CASUARINAS', NULL, NULL, NULL);

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
        'DAVID',
        '72377685',
        1,
        NULL,
        '$2y$10$Gb6hxDzJ/RktUr78H3DIu.abnJ7PjWdBp1MghWvhL1BdlVFmBDq1e',
        NULL,
        '2023-11-15 00:00:35',
        '2023-11-15 00:00:35'
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

-- Dump completed on 2023-11-14 21:06:14