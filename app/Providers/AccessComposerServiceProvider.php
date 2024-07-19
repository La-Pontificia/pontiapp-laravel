<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AccessComposerServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }


    public function boot(): void
    {


        View::composer('*', function ($view) {
            $system_privileges = [
                [
                    'name' => 'Gestión de Usuarios',
                    'items' => [
                        [
                            'name' => 'Usuarios',
                            'privileges' => [
                                'users:view' => 'Ver usuarios',
                                'users:create' => 'Agregar usuarios',
                                'users:asing_email' => 'Asignar correos',
                                'users:discharge' => 'Dar de baja correos',
                                'users:edit' => 'Actualizar usuarios',
                                'users:disable' => 'Deshabilitar usuarios',
                                'users:enable' => 'Habilitar usuarios',
                            ],
                        ],
                        [
                            'name' => 'Roles',
                            'privileges' => [
                                'users:user-roles:view' => 'Ver roles',
                                'users:user-roles:create' => 'Agregar roles',
                                'users:user-roles:edit' => 'Actualizar roles',
                                'users:user-roles:delete' => 'Eliminar roles',
                            ],
                        ],
                        [
                            'name' => 'Horarios',
                            'privileges' => [
                                'users:schedules:view' => 'Ver horarios',
                                'users:schedules:create' => 'Agregar horarios',
                                'users:schedules:edit' => 'Actualizar horarios',
                                'users:schedules:delete' => 'Eliminar horarios',
                            ],
                        ],
                        [
                            'name' => 'Emails',
                            'privileges' => [
                                'users:emails:view' => 'Ver correos',
                                'users:emails:add' => 'Agregar correos',
                                'users:emails:edit' => 'Actualizar correos',
                                'users:emails:discharge' => 'Dar de baja',
                                'users:emails:delete' => 'Eliminar correos',
                            ],
                        ],
                        // [
                        //     'name' => 'Dominios',
                        //     'privileges' => [
                        //         'users:domains:view' => 'Ver dominios',
                        //         'users:domains:create' => 'Agregar dominios',
                        //         'users:domains:edit' => 'Actualizar dominios',
                        //         'users:domains:delete' => 'Eliminar dominios',
                        //     ],
                        // ],
                        [
                            'name' => 'Cargos',
                            'privileges' => [
                                'users:roles:view' => 'Ver cargos',
                                'users:roles:create' => 'Agregar cargos',
                                'users:roles:edit' => 'Actualizar cargos',
                                'users:roles:delete' => 'Eliminar cargos',
                            ],
                        ],
                        [
                            'name' => 'Puestos',
                            'privileges' => [
                                'users:job-positions:view' => 'Ver puestos',
                                'users:job-positions:create' => 'Agregar puestos',
                                'users:job-positions:edit' => 'Actualizar puestos',
                                'users:job-positions:delete' => 'Eliminar puestos',
                            ],
                        ],
                        // [
                        //     'name' => 'Sesiones',
                        //     'privileges' => [
                        //         'users:sessions:view' => 'Ver sesiones',
                        //         'users:sessions:delete' => 'Eliminar sesiones',
                        //     ],
                        // ],
                        // [
                        //     'name' => 'Reportes',
                        //     'privileges' => [
                        //         'users:reports:view' => 'Ver reportes',
                        //         'users:reports:generate' => 'Generar reportes',
                        //     ],
                        // ],
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
                    'name' => 'Gestion de Edas',
                    'items' => [
                        [
                            'name' => 'Edas',
                            'privileges' => [
                                'edas:view_all' => 'Ver todas las edas',
                                'edas:view' => 'Ver edas que supervisa',
                                'edas:create_all' => 'Registrar todas las edas',
                                'edas:create' => 'Registrar edas que supervisa',
                                'edas:delete' => 'Resetear edas',
                                'edas:close_all' => 'Cerrar todas las edas',
                                'edas:close' => 'Cerrar las edas que supervisa',
                            ],
                        ],
                        [
                            'name' => 'Colaboradores',
                            'privileges' => [
                                'edas:collaborators:view_all' => 'Ver todos colaboradores',
                                'edas:collaborators:view' => 'Ver los colaboradores que supervisa',
                                'edas:collaborators:create' => 'Crear colaboradores',
                                'edas:collaborators:assign_supervisors' => 'Asignar supervisores',
                            ],
                        ],
                        [
                            'name' => 'Objetivos',
                            'privileges' => [
                                'edas:goals:view' => 'Ver objetivos',
                                'edas:goals:send' => 'Enviar objetivos',
                                'edas:goals:edit' => 'Editar objetivos',
                                'edas:goals:delete' => 'Eliminar objetivos',
                                'edas:evaluations:approve' => 'Aprobar objetivos',
                            ],
                        ],
                        [
                            'name' => 'Evaluaciones',
                            'privileges' => [
                                'edas:evaluations:self-qualify' => 'Autocalificar objetivos',
                                'edas:evaluations:qualify' => 'Calificar objetivos',
                                'edas:evaluations:view' => 'Ver evaluaciones',
                                'edas:evaluations:close' => 'Cerrar evaluaciones',
                            ],
                        ],
                        [
                            'name' => 'Cuestionarios',
                            'privileges' => [
                                'edas:questionnaires:respond' => 'Responder cuestionarios',
                                'edas:questionnaires:view' => 'Ver cuestionarios',
                                'edas:questionnaires:generate_report' => 'Generar reportes de cuestionarios',
                            ],
                        ],
                        [
                            'name' => 'Reportes',
                            'privileges' => [
                                'edas:reports:view' => 'Ver reportes',
                                'edas:reports:generate' => 'Generar reportes',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Mantenimiento',
                    'items' => [
                        [
                            'name' => 'Areas',
                            'privileges' => [
                                'maintenance:areas:view' => 'Ver areas',
                                'maintenance:areas:create' => 'Agregar areas',
                                'maintenance:areas:edit' => 'Actualizar areas',
                                'maintenance:areas:delete' => 'Eliminar areas',
                            ],
                        ],
                        [
                            'name' => 'Departamentos',
                            'privileges' => [
                                'maintenance:department:view' => 'Ver departamentos',
                                'maintenance:department:create' => 'Agregar departamentos',
                                'maintenance:department:edit' => 'Actualizar departamentos',
                                'maintenance:department:delete' => 'Eliminar departamentos',
                            ],
                        ],

                        [
                            'name' => 'Sedes',
                            'privileges' => [
                                'maintenance:branches:view' => 'Ver sedes',
                                'maintenance:branches:create' => 'Agregar sedes',
                                'maintenance:branches:edit' => 'Actualizar sedes',
                                'maintenance:branches:delete' => 'Eliminar sedes',
                            ],
                        ],
                    ],
                ],
            ];

            $user = auth()->user();
            if ($user) {
                $view->with('current_user', $user);
                $view->with('cuser', $user);
                $view->with('system_privileges', $system_privileges);
            }
        });
    }
}
