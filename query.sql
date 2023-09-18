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
    ('C006', 'ANALISTA', NOW());




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
        `id_departamento`,
        `created_at`
    )
VALUES
    (
        'P001',
        'COORDINADOR ACADÉMICO C. GESTIÓN Y TI',
        1,
        NOW()
    ),
    (
        'P002',
        'JEFE ACADÉMICO C. GESTIÓN Y TI',
        1,
        NOW()
    ),
    (
        'P003',
        'DIRECTOR ACADÉMICO',
        1,
        NOW()
    ),
    (
        'P004',
        'JEFE ACADÉMICO C. SALUD',
        1,
        NOW()
    ),
    (
        'P005',
        'SSS',
        1,
        NOW()
    ),
    (
        'P006',
        'DIRECTOR ADMINISTRATIVO',
        1,
        NOW()
    ),
    (
        'P007',
        'DIRECTOR DE INVESTIGACIÓN E INNOVACIÓN ',
        1,
        NOW()
    ),
    (
        'P008',
        'DIRECTOR GENERAL',
        1,
        NOW()
    ),
    (
        'P009',
        'DIRECTORA DE GESTIÓN Y FINANZAS ',
        1,
        NOW()
    ),
    (
        'P010',
        'DIRECTORA DE MARKETING Y COMERCIAL',
        1,
        NOW()
    ),
    (
        'P011',
        'JEFE DE ADMISIÓN',
        1,
        NOW()
    ),
    (
        'P012',
        'JEFE DE ADMISIÓN ELP',
        1,
        NOW()
    ),
    (
        'P013',
        'JEFE DE COMUNICACIONES ',
        1,
        NOW()
    ),
    (
        'P014',
        'JEFE DE GESTIÓN DE PERSONAS',
        1,
        NOW()
    ),
    (
        'P015',
        'JEFE DE REGISTRO DE GRADOS Y TÍTULOS ',
        1,
        NOW()
    ),
    (
        'P016',
        'JEFE DE SECRETARÍA ACADÉMICA  ',
        1,
        NOW()
    ),
    (
        'P017',
        'JEFE DE SISTEMAS',
        1,
        NOW()
    ),
    (
        'P018',
        'COORDINADOR ACADÉMICO C. SALUD',
        1,
        NOW()
    ),
    (
        'P019',
        'COORDINADOR DE ATENCIÓN AL ESTUDIANTE',
        1,
        NOW()
    ),
    (
        'P020',
        'COORDINADOR DE BIENESTAR ',
        1,
        NOW()
    ),
    (
        'P021',
        'COORDINADOR DE CALIDAD EDUCATIVA',
        1,
        NOW()
    ),
    (
        'P022',
        'COORDINADOR DE CESTIFICACIONES',
        1,
        NOW()
    ),
    (
        'P023',
        'COORDINADOR DE CLOUD, REDES Y CONECTIVIDAD  ',
        1,
        NOW()
    ),
    (
        'P024',
        'COORDINADOR DE COMUNICACIONES DE EC Y CI ',
        1,
        NOW()
    ),
    (
        'P025',
        'COORDINADOR DE COMUNICACIONES ELP ',
        1,
        NOW()
    ),
    (
        'P026',
        'COORDINADOR DE COMUNICACIONES ILP ',
        1,
        NOW()
    ),
    (
        'P027',
        'COORDINADOR DE CONTABILIDAD',
        1,
        NOW()
    ),
    (
        'P028',
        'COORDINADOR DE EDUCACIÓN CONTINUA ',
        1,
        NOW()
    ),
    (
        'P029',
        'COORDINADOR DE EXPERIENCIA DEL ESTUDIANTE',
        1,
        NOW()
    ),
    (
        'P030',
        'COORDINADOR DE RECAUDACIONES  ',
        1,
        NOW()
    ),
    (
        'P031',
        'COORDINADOR DE SECRETARÍA ACADÉMICA ILP',
        1,
        NOW()
    ),
    (
        'P032',
        'COORDINADOR DE SERVICIOS Y DEMANDA',
        1,
        NOW()
    ),
    (
        'P033',
        'COORDINADOR DE TALENTO ',
        1,
        NOW()
    ),
    (
        'P034',
        'COORDINADOR DE TESORERÍA ',
        1,
        NOW()
    ),
    (
        'P035',
        'COORDINADOR DEL CENTRO DE IDIOMAS ',
        1,
        NOW()
    ),
    (
        'P036',
        'COORDINADOR DEL CENTRO DE INFORMACIÓN',
        1,
        NOW()
    ),
    (
        'P037',
        'COORDINADOR DE INFRAESTRUCTURA',
        1,
        NOW()
    ),
    (
        'P038',
        'ASESOR DE ADMISIÓN CI  ',
        1,
        NOW()
    ),
    (
        'P039',
        'ASESOR DE ADMISIÓN EC  ',
        1,
        NOW()
    ),
    (
        'P040',
        'ASESOR DE ADMISIÓN ELP ',
        1,
        NOW()
    ),
    (
        'P041',
        'ASESOR DE ADMISIÓN ELP Y ILP  ',
        1,
        NOW()
    ),
    (
        'P042',
        'ASESOR DE ADMISIÓN ILP ',
        1,
        NOW()
    ),
    (
        'P043',
        'ASISTENTE ACADÉMICO C. GESTIÓN Y TI  ',
        1,
        NOW()
    ),
    (
        'P044',
        'ASISTENTE ACADÉMICO C. SALUD  ',
        1,
        NOW()
    ),
    (
        'P045',
        'ASISTENTE ADMINISTRATIVO ',
        1,
        NOW()
    ),
    (
        'P046',
        'ASISTENTE DE ATENCIÓN AL ESTUDIANTE  ',
        1,
        NOW()
    ),
    (
        'P047',
        'ASISTENTE DE BIENESTAR ',
        1,
        NOW()
    ),
    (
        'P048',
        'ASISTENTE DE BOLSA DE TRABAJO ',
        1,
        NOW()
    ),
    (
        'P049',
        'ASISTENTE DE CERTIFICACIONES  ',
        1,
        NOW()
    ),
    (
        'P050',
        'ASISTENTE DE COMUNICACIONES DE EC Y CI ',
        1,
        NOW()
    ),
    (
        'P051',
        'ASISTENTE DE CONTABILIDAD',
        1,
        NOW()
    ),
    (
        'P052',
        'ASISTENTE DE DIRECCIÓN GENERAL',
        1,
        NOW()
    ),
    (
        'P053',
        'ASISTENTE DE EXPERIENCIA DEL ESTUDIANTE',
        1,
        NOW()
    ),
    (
        'P054',
        'ASISTENTE DE GRADOS Y TÍTULOS ',
        1,
        NOW()
    ),
    (
        'P055',
        'ASISTENTE DE INFRAESTRUCTURA  ',
        1,
        NOW()
    ),
    (
        'P056',
        'ASISTENTE DE MENTORIA  ',
        1,
        NOW()
    ),
    (
        'P057',
        'ASISTENTE DE RECAUDACIÓN ',
        1,
        NOW()
    ),
    (
        'P058',
        'ASISTENTE DE REDES SOCIALES',
        1,
        NOW()
    ),
    (
        'P059',
        'ASISTENTE DE SISTEMAS  ',
        1,
        NOW()
    ),
    (
        'P060',
        'ASISTENTE DE TESORERÍA ',
        1,
        NOW()
    ),
    (
        'P061',
        'ASISTENTE DE TÓPICO ',
        1,
        NOW()
    ),
    (
        'P062',
        'ASISTENTE DEL CENTRO DE INDORMACIÓN  ',
        1,
        NOW()
    ),
    (
        'P063',
        'ASISTENTE SECRETARÍA ACADÉMICA ELP',
        1,
        NOW()
    ),
    (
        'P064',
        'ASISTENTE SECRETARÍA ACADÉMICA ILP',
        1,
        NOW()
    ),
    (
        'P065',
        'ANALISTA DE CALIDAD EDUCATIVA ',
        1,
        NOW()
    ),
    (
        'P066',
        'ANALISTA DE DISEÑO Y PRODUCCIÓN ILP  ',
        1,
        NOW()
    ),
    (
        'P067',
        'ANALISTA DE GESTIÓN DE PERSONAS ',
        1,
        NOW()
    ),
    (
        'P068',
        'ANALISTA DE MENTORIA',
        1,
        NOW()
    ),
    (
        'P069',
        'ANALISTA DE MESA DE AYUDA',
        1,
        NOW()
    ),
    (
        'P070',
        'ANALISTA DE TALENTO ',
        1,
        NOW()
    ),
    (
        'P071',
        'ANALISTA LEGAL  ',
        1,
        NOW()
    ),
    (
        'P072',
        'ANALISTA SECRETARIA ACADÉMICA ILP ',
        1,
        NOW()
    ),
    (
        'P073',
        'ANALISTA SENIOR DE FINANZAS',
        1,
        NOW()
    );