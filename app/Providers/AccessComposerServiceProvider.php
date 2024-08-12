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
                    'name' => 'Gestión de Usuarios',
                    'items' => [
                        [
                            'name' => 'Usuarios',
                            'privileges' => [
                                'users:show' => 'Ver usuarios',
                                'users:create' => 'Registrar usuarios',
                                'users:edit' => 'Actualizar usuarios',
                                'users:disable' => 'Deshabilitar usuarios',
                                'users:enable' => 'Habilitar usuarios',
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
                            'name' => 'Horarios',
                            'privileges' => [
                                'users:schedules:show' => 'Ver horarios',
                                'users:schedules:create' => 'Agregar horarios',
                                'users:schedules:edit' => 'Actualizar horarios',
                                'users:schedules:delete' => 'Eliminar horarios',
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
                        // [
                        //     'name' => 'Importar',
                        //     'privileges' => [
                        //         'users:import' => 'Importar usuarios',
                        //     ],
                        // ],
                        // [
                        //     'name' => 'Exportar',
                        //     'privileges' => [
                        //         'users:export' => 'Exportar usuarios',
                        //     ],
                        // ],

                    ],
                ],
                [
                    'name' => 'Gestión de asistencias',
                    'items' => [
                        [
                            'name' => 'Asistencias',
                            'privileges' => [
                                'assists:show' => 'Ver asistencias',
                                'assists:create' => 'Registrar asistencias',
                                'assists:edit' => 'Actualizar asistencias',
                                'assists:delete' => 'Eliminar asistencias',
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
