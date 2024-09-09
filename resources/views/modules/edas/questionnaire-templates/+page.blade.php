@extends('modules.edas.+layout')

@section('title', 'Mantenimiento: plantillas de encuestas')


@section('layout.edas')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Plantilla de cuestionarios para las edas.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('edas:questionnaire-templates:create') || $cuser->isDev())
                <a href="/edas/questionnaire-templates/create" class="primary m-2">
                    svg'bx-plus', 'w-5 h-5')
                    <span>Nuevo</span>
                </a>
            @endif
            <div class="flex flex-col divide-y">
                @if ($cuser->has('edas:questionnaire-templates:show') || $cuser->isDev())
                    @forelse ($templates as $template)
                        <div class="flex relative items-center hover:bg-neutral-100 p-3 gap-2">
                            svg'bx-file-blank', 'w-5 h-5 mr-2')
                            <div class="flex-grow">
                                <p>{{ $template->title }}</p>
                            </div>
                            <a href="/edas/questionnaire-templates/{{ $template->id }}" class="absolute inset-0"></a>
                            @if ($template->use_for !== null)
                                <span class="text-sm text-nowrap bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                    {{ $template->use_for === 'collaborators' ? 'Colaboradores' : 'Supervisores' }}
                                </span>
                            @endif
                            <p>
                                {{ $template->questions->count() }} preguntas
                            </p>
                            <button class="rounded-full p-2 hover:bg-neutral-200 relative transition-colors"
                                data-dropdown-toggle="dropdown-{{ $template->id }}">
                                svg'bx-dots-vertical-rounded', 'w-4 h-4')
                            </button>
                            <div id="dropdown-{{ $template->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('users:questionnaire-templates:edit') || $cuser->isDev())
                                    <button data-atitle="¿Usar como cuestionario para colaboradores?"
                                        data-adescription="Todos los colaboradores tendrán este cuestionario en sus edas."
                                        data-param="/api/questionnaire-templates/{{ $template->id }}/use/collaborators"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Usar para colaboradores
                                    </button>
                                    <button data-atitle="¿Usar como cuestionario para supervisores?"
                                        data-adescription="Todos los supervisores tendrán este cuestionario en sus edas."
                                        data-param="/api/questionnaire-templates/{{ $template->id }}/use/supervisors"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Usar para supervisores
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @endforelse
                @else
                    <p class="p-20 grid place-content-center text-center">
                        No tienes permisos para visualizar estos datos.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
