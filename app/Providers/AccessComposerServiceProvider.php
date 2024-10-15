<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AccessComposerServiceProvider extends ServiceProvider
{

    public function register(): void {}


    public function boot(): void
    {


        View::composer('*', function ($view) {
            $system_privileges = [
                [
                    'name' => 'Development',
                    'items' => [
                        [
                            'name' => 'Development',
                            'privileges' => [
                                'development' => 'Development',
                            ]
                        ],
                    ],
                ],
                [
                    'name' => 'Gestión Usuarios',
                    'items' => [
                        [
                            'name' => 'Usuarios',
                            'privileges' => [
                                'users:show' => 'Ver usuarios',
                                'users:asign-supervisor' => 'Asignar supervisores',
                                'users:create' => 'Registrar usuarios',
                                'users:edit' => 'Editar usuarios',
                                'users:toggle-disable' => 'Deshabilitar o habilitar usuarios',
                                'users:reset-password' => 'Restablecer contraseñas',
                                'users:export' => 'Exportar usuarios',

                            ],
                        ],
                        [
                            'name' => 'Roles',
                            'privileges' => [
                                'users:user-roles:show' => 'Ver roles',
                                'users:user-roles:create' => 'Agregar roles',
                                'users:user-roles:edit' => 'Actualizar roles',
                                'users:user-roles:delete' => 'Eliminar roles',
                            ],
                        ],
                        [
                            'name' => 'Correos y accesos',
                            'privileges' => [
                                'users:emails-access:show' => 'Ver correos y accesos',
                                'users:emails-access:edit' => 'Actualizar correos y accesos',
                            ],
                        ],

                        [
                            'name' => 'Puestos',
                            'privileges' => [
                                'users:job-positions:show' => 'Ver puestos',
                                'users:job-positions:create' => 'Agregar puestos',
                                'users:job-positions:edit' => 'Actualizar puestos',
                                'users:job-positions:delete' => 'Eliminar puestos',
                            ],
                        ],
                        [
                            'name' => 'Cargos',
                            'privileges' => [
                                'users:roles:show' => 'Ver cargos',
                                'users:roles:create' => 'Agregar cargos',
                                'users:roles:edit' => 'Actualizar cargos',
                                'users:roles:delete' => 'Eliminar cargos',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Gestión Horarios',
                    'items' => [
                        [
                            'name' => 'Horarios',
                            'privileges' => [
                                'schedules:show' => 'Ver horarios',
                                'schedules:create' => 'Agregar horarios',
                                'schedules:create_unique' => 'Agregar horarios únicos',
                                'schedules:edit' => 'Actualizar horarios',
                                'schedules:delete' => 'Eliminar horarios',
                            ],
                        ],
                        [
                            'name' => 'Horarios externos',
                            'privileges' => [
                                'schedules:external:show' => 'Ver horarios externos',
                                'schedules:external:create' => 'Agregar horarios externos',
                                'schedules:external:create_unique' => 'Agregar horarios únicos externos',
                                'schedules:external:edit' => 'Actualizar horarios externos',
                                'schedules:external:delete' => 'Eliminar horarios externos',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Gestión Asistencias',
                    'items' => [
                        [
                            'name' => 'Asistencias centralizadas',
                            'privileges' => [
                                'assists:show' => 'Ver asistencias',
                                'assists:export' => 'Export asistencias',
                            ],
                        ],
                        [
                            'name' => 'Asistencias centralizadas sin calcular',
                            'privileges' => [
                                'assists:sn-schedules' => 'Acceso completo',
                            ],
                        ],
                        [
                            'name' => 'Asistencias sin calcular',
                            'privileges' => [
                                'assists:without-calculating' => 'Acceso completo',
                            ],
                        ],
                        [
                            'name' => 'Resumen único de asistencias',
                            'privileges' => [
                                'assists:single-summary' => 'Acceso completo',
                            ],
                        ],
                        [
                            'name' => 'Terminales',
                            'privileges' => [
                                'assists:terminals:show' => 'Ver terminales',
                                'assists:terminals:create' => 'Agregar terminales',
                                'assists:terminals:edit' => 'Actualizar terminales',
                                'assists:terminals:delete' => 'Eliminar terminales',
                            ],
                        ]

                    ]
                ],
                [
                    'name' => 'Gestion de Edas',
                    'items' => [
                        [
                            'name' => 'Edas',
                            'privileges' => [
                                'edas:show_all' => 'Ver todas las edas',
                                'edas:show' => 'Ver edas que supervisa',
                                'edas:create_all' => 'Registrar todas las edas',
                                'edas:create' => 'Registrar edas que supervisa',
                                'edas:create_my' => 'Registrar sus edas',
                                'edas:delete' => 'Resetear edas',
                                'edas:close_all' => 'Cerrar todas las edas',
                                'edas:close' => 'Cerrar las edas que supervisa',
                                'edas:export' => 'Exportar edas',
                            ],
                        ],
                        [
                            'name' => 'Años',
                            'privileges' => [
                                'edas:years:show' => 'Ver los años',
                                'edas:years:edit' => 'Editar años',
                                'edas:years:create' => 'Registrar años',
                                'edas:years:delete' => 'Eliminar años',
                            ],
                        ],
                        [
                            'name' => 'Objetivos',
                            'privileges' => [
                                'edas:goals:show' => 'Ver objetivos',
                                'edas:goals:sent' => 'Enviar objetivos',
                                'edas:goals:edit' => 'Editar objetivos',
                                'edas:goals:delete' => 'Eliminar objetivos',
                                'edas:goals:approve' => 'Aprobar objetivos',
                            ],
                        ],
                        [
                            'name' => 'Evaluaciones',
                            'privileges' => [
                                'edas:evaluations:self-qualify' => 'Autocalificar objetivos',
                                'edas:evaluations:qualify' => 'Calificar objetivos',
                                'edas:evaluations:show' => 'Ver evaluaciones',
                                'edas:evaluations:close' => 'Cerrar evaluaciones',
                            ],
                        ],
                        [
                            'name' => 'Cuestionarios',
                            'privileges' => [
                                'edas:questionnaires:respond' => 'Responder cuestionarios',
                                'edas:questionnaires:generate_report' => 'Generar reportes de cuestionarios',
                            ],
                        ],

                        [
                            'name' => 'Plantilla de cuestionarios',
                            'privileges' => [
                                'edas:questionnaire-templates:show' => 'Ver plantillas de cuestionarios',
                                'edas:questionnaire-templates:create' => 'Crear plantillas de cuestionarios',
                                'edas:questionnaire-templates:edit' => 'Editar plantillas de cuestionarios',
                            ],
                        ],
                        [
                            'name' => 'Reportes',
                            'privileges' => [
                                'edas:reports:show' => 'Ver reportes',
                                'edas:reports:generate' => 'Generar reportes',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Gestion Eventos',
                    'items' => [
                        [
                            'name' => 'Eventos',
                            'privileges' => [
                                'events:show' => 'Ver eventos',
                                'events:edit' => 'Editar eventos',
                                'events:create' => 'Crear eventos',
                                'events:delete' => 'Eliminar eventos',
                            ],
                        ],
                        [
                            'name' => 'Asistencias a eventos',
                            'privileges' => [
                                'events:assists:show' => 'Asistencias a eventos',
                                'events:assists:register' => 'Registrar asistencias a eventos',
                                'events:assists:edit' => 'Editar asistencias a eventos',
                                'events:assists:delete' => 'Eliminar asistencias a eventos',
                                'events:assists:export' => 'Exportar asistencias a eventos',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Gestion Tickets',
                    'items' => [
                        [
                            'name' => 'Tickets',
                            'privileges' => [
                                'tickets:show' => 'Ver eventos',
                                'tickets:edit' => 'Editar eventos',
                                'tickets:create' => 'Crear eventos',
                                'tickets:delete' => 'Eliminar eventos',
                            ],
                        ],
                        [
                            "name" => 'Real Time',
                            'privileges' => [
                                'tickets:real-time:show' => 'Ver Real Time',
                                'tickets:real-time:edit' => 'Editar Real Time',
                                'tickets:real-time:create' => 'Crear Real Time',
                                'tickets:real-time:delete' => 'Eliminar Real Time',
                            ],
                        ]

                    ],
                ],
                [
                    'name' => 'Auditoria',
                    'items' => [
                        [
                            'name' => 'Auditoria',
                            'privileges' => [
                                'audit:show' => 'Ver auditoria',
                                'audit:delete' => 'Eliminar auditoria',
                                'audit:export' => 'Exportar auditoria',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Gestión de reportes',
                    'items' => [
                        [
                            'name' => 'Descargas',
                            'privileges' => [
                                'reports:dowloads:my' => 'Ver y descargar mis reportes',
                                'reports:dowloads:all' => 'Ver y descargar todos los reportes',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Ajustes del sistema',
                    'items' => [
                        [
                            'name' => 'Ajustes del sistema',
                            'privileges' => [
                                'settings:show' => 'Todos los ajustes',
                            ],
                        ],
                    ],
                ],
            ];

            $email_access = [
                [
                    'name' => 'Pontisis',
                    'code' => 'pontisis'
                ],
                [
                    'name' => 'Aula Virtual',
                    'code' => 'aula_virtual'
                ],
                [
                    'name' => 'MS. 365',
                    'code' =>  'ms_365'
                ],
                [
                    'name' => 'EDA',
                    'code' =>  'eda'
                ]
            ];

            $user = auth()->user();

            $business_services = [
                'pontisis' => 'Sistema Académico',
                'aula_virtual' => 'Aula Virtual',
                'ms_365' => 'MS. 365 - Microsoft 365',
                'eda' => 'EDA'
            ];

            $sidebarCookie = request()->cookie('sidebar');

            if ($user) {
                $view->with('current_user', $user);
                $view->with('cuser', $user);
                $view->with('system_privileges', $system_privileges);
                $view->with('email_access', $email_access);
                $view->with('business_services', $business_services);
                $view->with('sidebarCookie', $sidebarCookie);
            }
        });
    }
}
