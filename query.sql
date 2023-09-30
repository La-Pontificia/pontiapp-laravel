
INSERT INTO
    `areas` (`codigo_area`, `nombre_area`, `created_at`)
VALUES
    ('A001', 'ACADÉMICA', NOW()),
    ('A002', 'ADMINISTRATIVO', NOW()),
    ('A003', 'CENTRO DE IDIOMAS', NOW()),
    ('A004', 'CONTABILIDAD Y FINANZAS', NOW()),
    ('A005', 'EDUCACIÓN CONTINUA ', NOW()),
    ('A006', 'INVESTIGACIÓN E INNOVACIÓN', NOW()),
    ('A007', 'MARKETING Y COMERCIAL', NOW()),
    ('A008', 'SECRETARÍA GENERAL ', NOW()),
    ('A009', 'SISTEMAS', NOW()),
    ('A010', 'GESTIÓN DE PERSONAS', NOW());

INSERT INTO
    `cargos` (`codigo_cargo`, `nombre_cargo`, `created_at`)
VALUES
    ('C001', 'GERENTE GENERAL', NOW()),
    ('C002', 'DIRECTOR', NOW()),
    ('C003', 'JEFE', NOW()),
    ('C004', 'COORDINADOR', NOW()),
    ('C005', 'ASISTENTE', NOW()),
    ('C006', 'ANALISTA', NOW()),
    ('C007', 'ASESOR', NOW());




INSERT INTO
    `departamentos` (
        `codigo_departamento`,
        `nombre_departamento`,
        `id_area`,
        `created_at`
    )
VALUES
    (
        'D001',
        'ACADÉMICA DE C. GESTIÓN...',
        1,
        NOW()
    ),
    (
        'D002',
        'ATENCIÓN AL ESTUDIANTE',
        2,
        NOW()
    ),
    (
        'D003',
        'CONTABILIDAD',
        4,
        NOW()
    ),
    (
        'D004',
        'BIENESTAR',
        2,
        NOW()
    ),
    (
        'D005',
        'SISTEMAS',
        9,
        NOW()
    ),
    (
        'D006',
        'TALENTO HUMANO',
        10,
        NOW()
    );

INSERT INTO
    `puestos` (
        `codigo_puesto`,
        `nombre_puesto`,
        `id_cargo`,
        `id_departamento`,
        `created_at`
    )
VALUES
    (
        'P001',
        'COORDINADOR ACADÉMICO C. GESTIÓN Y TI',
        4,
        4,
        NOW()
    ),
    (
        'P002',
        'JEFE ACADÉMICO C. GESTIÓN Y TI',
        3,
        3,
        NOW()
    ),
    (
        'P003',
        'DIRECTOR ACADÉMICO',
        2,
        2,
        NOW()
    ),
    (
        'P004',
        'JEFE ACADÉMICO C. SALUD',
        3,
        3,
        NOW()
    ),
   
    (
        'P006',
        'DIRECTOR ADMINISTRATIVO',
        2,
        2,
        NOW()
    ),
    (
        'P007',
        'DIRECTOR DE INVESTIGACIÓN E INNOVACIÓN ',
        2,
        2,
        NOW()
    ),
    (
        'P008',
        'DIRECTOR GENERAL',
        2,
        2,
        NOW()
    ),
    (
        'P009',
        'DIRECTORA DE GESTIÓN Y FINANZAS ',
        2,
        2,
        NOW()
    ),
    (
        'P010',
        'DIRECTORA DE MARKETING Y COMERCIAL',
        2,
        2,
        NOW()
    ),
    (
        'P011',
        'JEFE DE ADMISIÓN',
        3,
        3,
        NOW()
    ),
    (
        'P012',
        'JEFE DE ADMISIÓN ELP',
        3,
        3,
        NOW()
    ),
    (
        'P013',
        'JEFE DE COMUNICACIONES ',
        3,
        3,
        NOW()
    ),
    (
        'P014',
        'JEFE DE GESTIÓN DE PERSONAS',
        3,
        3,
        NOW()
    ),
    (
        'P015',
        'JEFE DE REGISTRO DE GRADOS Y TÍTULOS ',
        3,
        3,
        NOW()
    ),
    (
        'P016',
        'JEFE DE SECRETARÍA ACADÉMICA  ',
        3,
        3,
        NOW()
    ),
    (
        'P017',
        'JEFE DE SISTEMAS',
        3,
        3,
        NOW()
    ),
    (
        'P018',
        'COORDINADOR ACADÉMICO C. SALUD',
        4,
        4,
        NOW()
    ),
    (
        'P019',
        'COORDINADOR DE ATENCIÓN AL ESTUDIANTE',
        4,
        4,
        NOW()
    ),
    (
        'P020',
        'COORDINADOR DE BIENESTAR ',
        4,
        4,
        NOW()
    ),
    (
        'P021',
        'COORDINADOR DE CALIDAD EDUCATIVA',
        4,
        4,
        NOW()
    ),
    (
        'P022',
        'COORDINADOR DE CESTIFICACIONES',
        4,
        4,
        NOW()
    ),
    (
        'P023',
        'COORDINADOR DE CLOUD, REDES Y CONECTIVIDAD  ',
        4,
        4,
        NOW()
    ),
    (
        'P024',
        'COORDINADOR DE COMUNICACIONES DE EC Y CI ',
        4,
        4,
        NOW()
    ),
    (
        'P025',
        'COORDINADOR DE COMUNICACIONES ELP ',
        4,
        4,
        NOW()
    ),
    (
        'P026',
        'COORDINADOR DE COMUNICACIONES ILP ',
        4,
        4,
        NOW()
    ),
    (
        'P027',
        'COORDINADOR DE CONTABILIDAD',
        4,
        4,
        NOW()
    ),
    (
        'P028',
        'COORDINADOR DE EDUCACIÓN CONTINUA ',
        4,
        4,
        NOW()
    ),
    (
        'P029',
        'COORDINADOR DE EXPERIENCIA DEL ESTUDIANTE',
        4,
        4,
        NOW()
    ),
    (
        'P030',
        'COORDINADOR DE RECAUDACIONES  ',
        4,
        4,
        NOW()
    ),
    (
        'P031',
        'COORDINADOR DE SECRETARÍA ACADÉMICA ILP',
        4,
        4,
        NOW()
    ),
    (
        'P032',
        'COORDINADOR DE SERVICIOS Y DEMANDA',
        4,
        4,
        NOW()
    ),
    (
        'P033',
        'COORDINADOR DE TALENTO ',
        4,
        4,
        NOW()
    ),
    (
        'P034',
        'COORDINADOR DE TESORERÍA ',
        4,
        4,
        NOW()
    ),
    (
        'P035',
        'COORDINADOR DEL CENTRO DE IDIOMAS ',
        4,
        4,
        NOW()
    ),
    (
        'P036',
        'COORDINADOR DEL CENTRO DE INFORMACIÓN',
        4,
        4,
        NOW()
    ),
    (
        'P037',
        'COORDINADOR DE INFRAESTRUCTURA',
        4,
        4,
        NOW()
    ),
    (
        'P038',
        'ASESOR DE ADMISIÓN CI  ',
        7,
        5,
        NOW()
    ),
    (
        'P039',
        'ASESOR DE ADMISIÓN EC  ',
        7,
        5,
        NOW()
    ),
    (
        'P040',
        'ASESOR DE ADMISIÓN ELP ',
        7,
        5,
        NOW()
    ),
    (
        'P041',
        'ASESOR DE ADMISIÓN ELP Y ILP  ',
        7,
        5,
        NOW()
    ),
    (
        'P042',
        'ASESOR DE ADMISIÓN ILP ',
        7,
        5,
        NOW()
    ),
    (
        'P043',
        'ASISTENTE ACADÉMICO C. GESTIÓN Y TI  ',
        5,
        5,
        NOW()
    ),
    (
        'P044',
        'ASISTENTE ACADÉMICO C. SALUD  ',
        5,
        5,
        NOW()
    ),
    (
        'P045',
        'ASISTENTE ADMINISTRATIVO ',
        5,
        5,
        NOW()
    ),
    (
        'P046',
        'ASISTENTE DE ATENCIÓN AL ESTUDIANTE  ',
        5,
        5,
        NOW()
    ),
    (
        'P047',
        'ASISTENTE DE BIENESTAR ',
        5,
        5,
        NOW()
    ),
    (
        'P048',
        'ASISTENTE DE BOLSA DE TRABAJO ',
        5,
        5,
        NOW()
    ),
    (
        'P049',
        'ASISTENTE DE CERTIFICACIONES  ',
        5,
        5,
        NOW()
    ),
    (
        'P050',
        'ASISTENTE DE COMUNICACIONES DE EC Y CI ',
        5,
        5,
        NOW()
    ),
    (
        'P051',
        'ASISTENTE DE CONTABILIDAD',
        5,
        5,
        NOW()
    ),
    (
        'P052',
        'ASISTENTE DE DIRECCIÓN GENERAL',
        5,
        5,
        NOW()
    ),
    (
        'P053',
        'ASISTENTE DE EXPERIENCIA DEL ESTUDIANTE',
        5,
        5,
        NOW()
    ),
    (
        'P054',
        'ASISTENTE DE GRADOS Y TÍTULOS ',
        5,
        5,
        NOW()
    ),
    (
        'P055',
        'ASISTENTE DE INFRAESTRUCTURA  ',
        5,
        5,
        NOW()
    ),
    (
        'P056',
        'ASISTENTE DE MENTORIA  ',
        5,
        5,
        NOW()
    ),
    (
        'P057',
        'ASISTENTE DE RECAUDACIÓN ',
        5,
        5,
        NOW()
    ),
    (
        'P058',
        'ASISTENTE DE REDES SOCIALES',
        5,
        5,
        NOW()
    ),
    (
        'P059',
        'ASISTENTE DE SISTEMAS  ',
        5,
        5,
        NOW()
    ),
    (
        'P060',
        'ASISTENTE DE TESORERÍA ',
        5,
        5,
        NOW()
    ),
    (
        'P061',
        'ASISTENTE DE TÓPICO ',
        5,
        5,
        NOW()
    ),
    (
        'P062',
        'ASISTENTE DEL CENTRO DE INDORMACIÓN  ',
        5,
        5,
        NOW()
    ),
    (
        'P063',
        'ASISTENTE SECRETARÍA ACADÉMICA ELP',
        5,
        5,
        NOW()
    ),
    (
        'P064',
        'ASISTENTE SECRETARÍA ACADÉMICA ILP',
        5,
        5,
        NOW()
    ),
    (
        'P065',
        'ANALISTA DE CALIDAD EDUCATIVA ',
        6,
        6,
        NOW()
    ),
    (
        'P066',
        'ANALISTA DE DISEÑO Y PRODUCCIÓN ILP  ',
        6,
        6,
        NOW()
    ),
    (
        'P067',
        'ANALISTA DE GESTIÓN DE PERSONAS ',
        6,
        6,
        NOW()
    ),
    (
        'P068',
        'ANALISTA DE MENTORIA',
        6,
        6,
        NOW()
    ),
    (
        'P069',
        'ANALISTA DE MESA DE AYUDA',
        6,
        6,
        NOW()
    ),
    (
        'P070',
        'ANALISTA DE TALENTO ',
        6,
        6,
        NOW()
    ),
    (
        'P071',
        'ANALISTA LEGAL  ',
        6,
        6,
        NOW()
    ),
    (
        'P072',
        'ANALISTA SECRETARIA ACADÉMICA ILP ',
        6,
        6,
        NOW()
    ),
    (
        'P073',
        'ANALISTA SENIOR DE FINANZAS',
        6,
        6,
        NOW()
    );
