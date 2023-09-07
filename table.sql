CREATE TABLE `dbo.EDA_Area` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Codigo_Area` varchar(10) DEFAULT NULL,
    `Nombre_Area` varchar(50) DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Actualizacion` TIMESTAMP DEFAULT NULL
);

INSERT INTO
    `dbo.EDA_Area` (`Codigo_Area`, `Nombre_Area`)
VALUES
    ('A001', 'ACADÉMICA'),
    ('A002', 'ADMINISTRATIVO'),
    ('A003', 'CENTRO DE IDIOMAS'),
    ('A004', 'CONTABILIDAD Y FINANZAS'),
    ('A005', 'EDUCACIÓN CONTINUA '),
    ('A006', 'INVESTIGACIÓN E INNOVACIÓN'),
    ('A007', 'MARKETING Y COMERCIAL'),
    ('A008', 'SECRETARÍA GENERAL '),
    ('A009', 'SISTEMAS'),
    ('A010', 'GESTIÓN DE PERSONAS');

----------------------------CARGO
CREATE TABLE `dbo.EDA_Cargo` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Nombre_Cargo` varchar(50) DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Actualizacion` TIMESTAMP DEFAULT NULL
);

INSERT INTO
    `dbo.EDA_Cargo` (`Nombre_Cargo`)
VALUES
    ('GERENTE GENERAL'),
    ('DIRECTOR'),
    ('JEFE'),
    ('COORDINADOR'),
    ('ASISTENTE'),
    ('ANALISTA');

----------------------------DEPARTAMENTO
CREATE TABLE `departamentos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `codigo_departamento` varchar(50) DEFAULT NULL,
    `nombre_departamento` varchar(50) DEFAULT NULL,
    `id_area` INT DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Actualizacion` TIMESTAMP DEFAULT NULL,
);

INSERT INTO
    `departamentos` (
        `codigo_departamento`,
        `nombre_departamento`,
        `id_area`
    )
VALUES
    (
        'D001',
        'ACADÉMICA DE C. GESTIÓN...',
        1,
    ),
    (
        'D002',
        'ATENCIÓN AL ESTUDIANTE',
        2,
    ),
    (
        'D003',
        'CONTABILIDAD',
        4,
    ),
    (
        'D004',
        'BIENESTAR',
        2,
    ),
    (
        'D005',
        'SISTEMAS',
        9,
    ),
    (
        'D006',
        'TALENTO HUMANO',
        10,
    );

----------------------------PUESTO
CREATE TABLE IF NOT EXISTS `dbo.EDA_Puesto` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `Codigo_puesto` VARCHAR(255) DEFAULT NULL,
    `Nombre_puesto` VARCHAR(255) DEFAULT NULL,
    `Id_Dapartamento` INT DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Actualizacion` TIMESTAMP DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `Id_Dapartamentoidx` (`Id_Dapartamento`),
    CONSTRAINT `Id_Dapartamento` FOREIGN KEY (`Id_Dapartamento`) REFERENCES `EDA_Departamento` (`Id`)
);

INSERT INTO
    `dbo.EDA_Puesto_Colaboradores` (
        `Codigo_puesto`,
        `Nombre_puesto`,
        `Id_Dapartamento`
    )
VALUES
    (
        'P001',
        'COORDINADOR ACADÉMICO C. GESTIÓN Y TI',
        1
    ),
    (
        'P002',
        'JEFE ACADÉMICO C. GESTIÓN Y TI',
        1
    ),
    (
        'P003',
        'DIRECTOR ACADÉMICO',
        1
    ),
    (
        'P004',
        'JEFE ACADÉMICO C. SALUD',
        1
    ),
    (
        'P005',
        'SSS',
        1
    ),
    (
        'P006',
        'DIRECTOR ADMINISTRATIVO',
        1
    ),
    (
        'P007',
        'DIRECTOR DE INVESTIGACIÓN E INNOVACIÓN ',
        1
    ),
    (
        'P008',
        'DIRECTOR GENERAL',
        1
    ),
    (
        'P009',
        'DIRECTORA DE GESTIÓN Y FINANZAS ',
        1
    ),
    (
        'P010',
        'DIRECTORA DE MARKETING Y COMERCIAL',
        1,
    ),
    (
        'P011',
        'JEFE DE ADMISIÓN',
        1
    ),
    (
        'P012',
        'JEFE DE ADMISIÓN ELP',
        1
    ),
    (
        'P013',
        'JEFE DE COMUNICACIONES ',
        1
    ),
    (
        'P014',
        'JEFE DE GESTIÓN DE PERSONAS',
        1
    ),
    (
        'P015',
        'JEFE DE REGISTRO DE GRADOS Y TÍTULOS ',
        1
    ),
    (
        'P016',
        'JEFE DE SECRETARÍA ACADÉMICA  ',
        1
    ),
    (
        'P017',
        'JEFE DE SISTEMAS',
        1
    ),
    (
        'P018',
        'COORDINADOR ACADÉMICO C. SALUD',
        '28302883',
        1
    ),
    (
        'P019',
        'COORDINADOR DE ATENCIÓN AL ESTUDIANTE',
        1
    ),
    (
        'P020',
        'COORDINADOR DE BIENESTAR ',
        1
    ),
    (
        'P021',
        'COORDINADOR DE CALIDAD EDUCATIVA',
        1
    ),
    (
        'P022',
        'COORDINADOR DE CESTIFICACIONES',
        1
    ),
    (
        'P023',
        'COORDINADOR DE CLOUD, REDES Y CONECTIVIDAD  ',
        1
    ),
    (
        'P024',
        'COORDINADOR DE COMUNICACIONES DE EC Y CI ',
        1
    ),
    (
        'P025',
        'COORDINADOR DE COMUNICACIONES ELP ',
        1
    ),
    (
        'P026',
        'COORDINADOR DE COMUNICACIONES ILP ',
        1
    ),
    (
        'P027',
        'COORDINADOR DE CONTABILIDAD',
        1
    ),
    (
        'P028',
        'COORDINADOR DE EDUCACIÓN CONTINUA ',
        1
    ),
    (
        'P029',
        'COORDINADOR DE EXPERIENCIA DEL ESTUDIANTE',
        1
    ),
    (
        'P030',
        'COORDINADOR DE RECAUDACIONES  ',
        1
    ),
    (
        'P031',
        'COORDINADOR DE SECRETARÍA ACADÉMICA ILP',
        1
    ),
    (
        'P032',
        'COORDINADOR DE SERVICIOS Y DEMANDA',
        1
    ),
    (
        'P033',
        'COORDINADOR DE TALENTO ',
        1
    ),
    (
        'P034',
        'COORDINADOR DE TESORERÍA ',
        1
    ),
    (
        'P035',
        'COORDINADOR DEL CENTRO DE IDIOMAS ',
        1
    ),
    (
        'P036',
        'COORDINADOR DEL CENTRO DE INFORMACIÓN',
        1
    ),
    (
        'P037',
        'COORDINADOR DE INFRAESTRUCTURA',
        1
    ),
    (
        'P038',
        'ASESOR DE ADMISIÓN CI  ',
        1
    ),
    (
        'P039',
        'ASESOR DE ADMISIÓN EC  ',
        1
    ),
    (
        'P040',
        'ASESOR DE ADMISIÓN ELP ',
        1
    ),
    (
        'P041',
        'ASESOR DE ADMISIÓN ELP Y ILP  ',
        1
    ),
    (
        'P042',
        'ASESOR DE ADMISIÓN ILP ',
        1
    ),
    (
        'P043',
        'ASISTENTE ACADÉMICO C. GESTIÓN Y TI  ',
        1
    ),
    (
        'P044',
        'ASISTENTE ACADÉMICO C. SALUD  ',
        1
    ),
    (
        'P045',
        'ASISTENTE ADMINISTRATIVO ',
        1
    ),
    (
        'P046',
        'ASISTENTE DE ATENCIÓN AL ESTUDIANTE  ',
        1
    ),
    (
        'P047',
        'ASISTENTE DE BIENESTAR ',
        1
    ),
    (
        'P048',
        'ASISTENTE DE BOLSA DE TRABAJO ',
        1
    ),
    (
        'P049',
        'ASISTENTE DE CERTIFICACIONES  ',
        1
    ),
    (
        'P050',
        'ASISTENTE DE COMUNICACIONES DE EC Y CI ',
        1
    ),
    (
        'P051',
        'ASISTENTE DE CONTABILIDAD',
        1
    ),
    (
        'P052',
        'ASISTENTE DE DIRECCIÓN GENERAL',
        1
    ),
    (
        'P053',
        'ASISTENTE DE EXPERIENCIA DEL ESTUDIANTE',
        1
    ),
    (
        'P054',
        'ASISTENTE DE GRADOS Y TÍTULOS ',
        1
    ),
    (
        'P055',
        'ASISTENTE DE INFRAESTRUCTURA  ',
        1
    ),
    (
        'P056',
        'ASISTENTE DE MENTORIA  ',
        1
    ),
    (
        'P057',
        'ASISTENTE DE RECAUDACIÓN ',
        1
    ),
    (
        'P058',
        'ASISTENTE DE REDES SOCIALES',
        1
    ),
    (
        'P059',
        'ASISTENTE DE SISTEMAS  ',
        1
    ),
    (
        'P060',
        'ASISTENTE DE TESORERÍA ',
        1
    ),
    (
        'P061',
        'ASISTENTE DE TÓPICO ',
        1
    ),
    (
        'P062',
        'ASISTENTE DEL CENTRO DE INDORMACIÓN  ',
        1
    ),
    (
        'P063',
        'ASISTENTE SECRETARÍA ACADÉMICA ELP',
        1
    ),
    (
        'P064',
        'ASISTENTE SECRETARÍA ACADÉMICA ILP',
        1
    ),
    (
        'P065',
        'ANALISTA DE CALIDAD EDUCATIVA ',
        1
    ),
    (
        'P066',
        'ANALISTA DE DISEÑO Y PRODUCCIÓN ILP  ',
        1
    ),
    (
        'P067',
        'ANALISTA DE GESTIÓN DE PERSONAS ',
        1
    ),
    (
        'P068',
        'ANALISTA DE MENTORIA',
        1
    ),
    (
        'P069',
        'ANALISTA DE MESA DE AYUDA',
        1
    ),
    (
        'P070',
        'ANALISTA DE TALENTO ',
        1
    ),
    (
        'P071',
        'ANALISTA LEGAL  ',
        1
    ),
    (
        'P072',
        'ANALISTA SECRETARIA ACADÉMICA ILP ',
        1
    ),
    (
        'P073',
        'ANALISTA SENIOR DE FINANZAS',
        1
    );

----------------------------COLABORADOR
CREATE TABLE `colaboradores` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `dni` INT(8) DEFAULT NULL,
    `apellidos` varchar(40) DEFAULT NULL,
    `nombres` varchar(40) DEFAULT NULL,
    `id_cargo` INT DEFAULT NULL,
    `id_puesto` INT DEFAULT NULL,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `fecha_actualizacion` TIMESTAMP DEFAULT NULL,
    `estado` INT DEFAULT 1,
    KEY `id_cargoidx` (`id_cargo`),
    KEY `id_puestoidx` (`id_puesto`),
    CONSTRAINT `id_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`),
    CONSTRAINT `id_puesto` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id`)
);

INSERT INTO
    `dbo.EDA_Colaboradores` (
        `Dni`,
        `Apellidos`,
        `Nombre`,
        `Id_Cargo`,
        `Id_Puesto`
    )
VALUES
    (
        28302883,
        'SALCEDO ARRIARAN',
        'HENRY',
        3,
        17
    );

----------------------------LOGIN
CREATE TABLE `dbo.EDA_Login` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Id_Colaborador` int(11) DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Baja` TIMESTAMP DEFAULT NULL,
    `Usuario` varchar(10) DEFAULT NULL,
    `Clave` varchar(15) DEFAULT NULL,
    `Nivel_Usuario` INT DEFAULT 3
);

----------------------------ACCESO
CREATE TABLE `dbo.EDA_acceso` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Id_Colaborador` INT DEFAULT NULL,
    `Modulo` varchar(50) DEFAULT NULL,
    `Acceso` INT DEFAULT 0
);

INSERT INTO
    `dbo.EDA_Acceso` (`Id_Colaborador`, `Modulo`, `Acceso`)
VALUES
    (1, `Colaboradores`, 1),
    (1, `Departamentos`, 1),
    (1, `Areas`, 1),
    (1, `Puestos`, 1),
    (1, `Cargos`, 1),
    (1, `Objetivos`, 1),
    (1, `Acceso`, 1);

----------------------------SUPERVISORES
CREATE TABLE `dbo.EDA_Supervisor` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Id_Colaborador` INT DEFAULT NULL,
    `Id_Supervisor` INT DEFAULT NULL,
    `Fecha_Registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Fecha_Actualizacion` TIMESTAMP DEFAULT NULL,
);

----------------------------OBJETIVOS
CREATE TABLE `dbo.EDA_Objetivo` (
    `Id` INT NOT NULL AUTO_INCREMENT,
    `Id_Colaborador` int(11) DEFAULT NULL,
    `Objetivo` varchar(200) DEFAULT NULL,
    `Descripcion_Objetivo` varchar(4) DEFAULT NULL,
    `Porcentaje` tinyint(4) DEFAULT NULL,
    `Indicadores_Objetivo` varchar(8) DEFAULT NULL,
    `Fecha_Vencimiento` varchar(10) DEFAULT NULL,
    `Ano_Actividad` smallint(6) DEFAULT NULL,
);

----------------------------APROBACIONES
CREATE TABLE `dbo.EDA_Aprobacion` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `id_objetivo` varchar(10) DEFAULT NULL,
    --
    `Fecha_Aprobacion` varchar(10) DEFAULT NULL,
    `Aprobado` 1 DEFAULT NULL,
    --
    `Puntaje_01` decimal(3, 2) DEFAULT NULL,
    `Evaluacion_1` varchar(0) DEFAULT NULL,
    `Aprobado_Evaluacion_01` INT DEFAULT NULL,
    `fecha_Calificacion_01` varchar(0) DEFAULT NULL,
    `fecha_Aprobacion_01` varchar(0) DEFAULT NULL,
    `Cerrar_Eda_01` 1 DEFAULT NULL,
    --
    `Puntaje_02` decimal(3, 2) DEFAULT NULL,
    `Evaluacion_2` varchar(0) DEFAULT NULL,
    `Aprobado_Evaluacion_02` INT DEFAULT NULL,
    `fecha_Calificacion_02` varchar(0) DEFAULT NULL,
    `fecha_Aprobacion_02` varchar(0) DEFAULT NULL,
    `Cerrar_Eda_02` 1 DEFAULT NULL,
    --
    `Cerrar_Eda_Final` 1 DEFAULT NULL,
    `Fecha_Eda_Final` varchar(0) DEFAULT NULL
);