@extends('modules.edas.+layout')

@section('title', 'Mantenimiento: plantillas de encuestas')

@php
    $forList = [
        'collaborators' => 'Colaboradores',
        'supervisors' => 'Supervisores',
    ];
@endphp

@section('layout.edas')
    <div>
        <nav class="border-b p-2 flex gap-3">
            @if ($cuser->has('edas:questionnaire-templates:create') || $cuser->isDev())
                <a href="/edas/questionnaire-templates/create"
                    class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-1.5 gap-1 text-white text-sm px-3">
                    @svg('heroicon-o-plus', ['class' => 'w-5 h-5'])
                    <span class="max-lg:hidden">Crear plantilla</span>
                </a>
            @endif
            {{-- <select class="dinamic-select bg-transparent p-1 border-transparent rounded-lg cursor-pointer" name="for">
                <option value="0">Todos</option>
                @foreach ($forList as $key => $value)
                    <option {{ request()->query('for') === $key ? 'selected' : '' }} value="{{ $key }}">
                        {{ $value }}</option>
                @endforeach
            </select> --}}
        </nav>
        <div class="overflow-auto flex-grow">
            @if ($cuser->has('edas:questionnaire-templates:show') || $cuser->isDev())
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-4 [&>th]:px-2">
                            <th class="text-center">N°</th>
                            <th>Dirigidos para</th>
                            <th>Preguntas</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($templates->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay nada por aquí
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($templates as $index => $template)
                                <tr
                                    class="[&>td]:py-4 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                    <td class="text-center font-semibold">
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            @if ($cuser->has('edas:questionnaire-templates:edit') || $cuser->isDev())
                                                <a href="/edas/questionnaire-templates/{{ $template->id }}"
                                                    class="absolute inset-0 block">
                                                </a>
                                            @endif
                                            <p class="font-medium flex-grow">
                                                {{ $template->title }}
                                            </p>
                                            @if ($template->in_use)
                                                <div class="flex items-center gap-1.5">
                                                    <div class="w-2 aspect-square rounded-full bg-green-500">
                                                    </div>
                                                    <p class="font-medium">
                                                        En uso
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-nowrap font-medium text-blue-600">
                                            {{ $template->for === 'collaborators' ? 'Colaboradores' : 'Supervisores' }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="/edas/questionnaire-templates/{{ $template->id }}/questions"
                                            class="text-nowrap relative text-blue-600 hover:underline">
                                            {{ $template->questions->count() }}
                                            {{ $template->questions->count() === 1 ? 'Pregunta' : 'Preguntas' }}
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($template->created_at)->isoFormat('LL') }}
                                        </p>
                                    </td>
                                    <td>
                                        <button data-dropdown-toggle="dropdown-template-{{ $template->id }}"
                                            class="group-hover:opacity-100 relative opacity-0 hover:bg-neutral-200/80 rounded-md p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-ellipsis">
                                                <circle cx="12" cy="12" r="1" />
                                                <circle cx="19" cy="12" r="1" />
                                                <circle cx="5" cy="12" r="1" />
                                            </svg>
                                        </button>

                                        <div id="dropdown-template-{{ $template->id }}"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                            <button data-alertvariant="warning" data-atitle="¿Usar cuestionario?"
                                                data-adescription="Todas los edas tendrán esta encuesta como preterminado para los {{ $template->for === 'collaborators' ? 'Colaboradores' : 'Supervisores' }}."
                                                data-param="/api/questionnaire-templates/{{ $template->id }}/use"
                                                class="p-2 text-left dinamic-alert hover:bg-neutral-100 w-full block rounded-md hover:bg-gray-10">
                                                Usar cuestionario
                                            </button>
                                            <button data-alertvariant="warning" data-atitle="Archivar cuestionario"
                                                data-adescription="El cuestionario no se podrá usar más en los edas."
                                                data-param="/api/questionnaire-templates/{{ $template->id }}/archive"
                                                class="p-2 text-left dinamic-alert hover:bg-neutral-100 w-full block rounded-md hover:bg-gray-10">
                                                Archivar
                                            </button>
                                            <button data-alertvariant="warning" data-atitle="Eliminar plantilla"
                                                data-adescription="Se eliminarán las preguntas y respuestas tanto archivados y demás de este cuestionario."
                                                data-param="/api/questionnaire-templates/{{ $template->id }}/delete"
                                                class="p-2 text-left dinamic-alert hover:bg-neutral-100 w-full block rounded-md text-red-500 hover:bg-gray-10">
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @else
                @include('+403', [
                    'message' => 'No tienes permisos para visualizar los años de las edas.',
                ])
            @endif
        </div>
        {{-- <div class="w-full overflow-y-auto">
            <table class="w-full">
                <thead class="border-b text-left">
                    <tr class="text-sm [&>th]:p-2  [&>th]:text-nowrap [&>th]:font-semibold uppercase">
                        <th class="text-center">N°</th>
                        <th>Nombre</th>
                        <th>Dirigidos para</th>
                        <th>Preguntas</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th>En uso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($templates->isEmpty())
                        <tr>
                            <td class="text-center" colspan="20">
                                <div class="p-20">
                                    <svg class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="30"
                                        height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-table-rows-split">
                                        <path d="M14 10h2" />
                                        <path d="M15 22v-8" />
                                        <path d="M15 2v4" />
                                        <path d="M2 10h2" />
                                        <path d="M20 10h2" />
                                        <path d="M3 19h18" />
                                        <path d="M3 22v-6a2 2 135 0 1 2-2h14a2 2 45 0 1 2 2v6" />
                                        <path d="M3 2v2a2 2 45 0 0 2 2h14a2 2 135 0 0 2-2V2" />
                                        <path d="M8 10h2" />
                                        <path d="M9 22v-8" />
                                        <path d="M9 2v4" />
                                    </svg>
                                    No se encontraron registros
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($templates as $index => $template)
                            <tr class="even:bg-neutral-200/50 [&>td]:px-2">
                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="font-medium">
                                    {{ $template->title }}
                                </td>
                                <td>
                                    <p class="text-nowrap {{ $template->in_use ? 'text-lime-600' : '' }}">
                                        {{ $template->for === 'collaborators' ? 'Colaboradores' : 'Supervisores' }}
                                    </p>
                                </td>
                                <td>
                                    <a href="/edas/questionnaire-templates/{{ $template->id }}/questions"
                                        class="text-nowrap text-blue-600 hover:underline text-sm">
                                        {{ $template->questions->count() }}
                                        {{ $template->questions->count() === 1 ? 'Pregunta' : 'Preguntas' }}
                                    </a>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                            <img src={{ $template->createdBy->profile }} class="w-full h-full object-cover"
                                                alt="">
                                        </div>
                                        <div>
                                            <a href="/profile/{{ $template->createdBy->id }}"
                                                title="Ver perfil de {{ $template->createdBy->last_name }}, {{ $template->createdBy->first_name }}"
                                                class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                {{ $template->createdBy->last_name }},
                                                {{ $template->createdBy->first_name }}
                                            </a>
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($template->created_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex p-1 items-center gap-3">
                                        @if ($template->updatedBy)
                                            <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                                <img src={{ $template->updatedBy->profile }}
                                                    class="w-full h-full object-cover" alt="">
                                            </div>
                                        @endif
                                        <div>
                                            @if ($template->updatedBy)
                                                <a href="/profile/{{ $template->updatedBy->id }}"
                                                    title="Ver perfil de {{ $template->updatedBy->last_name }}, {{ $template->updatedBy->first_name }}"
                                                    class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                    {{ $template->updatedBy->last_name }},
                                                    {{ $template->updatedBy->first_name }}
                                                </a>
                                            @endif
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($template->updated_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button data-id="{{ $template->id }}"
                                        class="mx-auto text-sm font-semibold hover:bg-neutral-200 p-1 rounded-md px-2 change-template-in-use text-nowrap">
                                        Usar
                                    </button>
                                </td>
                                <td>
                                    <a href="/edas/questionnaire-templates/{{ $template->id }}/questions"
                                        class="font-semibold text-sm hover:underline text-blue-600">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div> --}}
    </div>
@endsection
