@extends('modules.edas.+layout')

@section('title', 'Mantenimiento: Edas (años)')


@section('layout.edas')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Años para implementar las edas.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('edas:years:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    @svg('fluentui-document-arrow-down-20-o', 'w-5 h-5')
                    <span>Nuevo</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar nuevo año
                        </header>
                        <form action="/api/years" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                            @include('modules.edas.years.form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif
            <div class="flex flex-col divide-y">
                @if ($cuser->has('edas:years:show') || $cuser->isDev())
                    @forelse ($years as $year)
                        <div class="flex relative items-center p-3 gap-2">
                            @svg('fluentui-document-link-20-o', 'w-5 h-5')
                            <div class="flex-grow">
                                <p>{{ $year->name }}</p>
                            </div>

                            @if ($year->status)
                                <span class="text-sm text-nowrap bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                    Abierto
                                </span>
                            @endif

                            <button type="button" data-modal-target="dialog-{{ $year->id }}"
                                data-modal-toggle="dialog-{{ $year->id }}"
                                class="rounded-full p-2 hover:bg-stone-200 transition-colors">
                                @svg('fluentui-document-edit-20-o', 'w-5 h-5')
                            </button>

                            <div id="dialog-{{ $year->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar año: {{ $year->title }}
                                    </header>
                                    <form action="/api/years/{{ $year->id }}" method="POST" id="dialog-form"
                                        class="dinamic-form body grid gap-4">
                                        @include('modules.edas.years.form', [
                                            'year' => $year,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $year->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $year->id }}-form" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                            <button class="rounded-full p-2 hover:bg-stone-200 relative transition-colors"
                                data-dropdown-toggle="dropdown-{{ $year->id }}">
                                @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                            </button>
                            <div id="dropdown-{{ $year->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('users:questionnaire-templates:edit') || $cuser->isDev())
                                    <button data-atitle="Abrir o cerrar año"
                                        data-adescription="¿Estas seguro de {{ $year->status ? 'cerrar' : 'abrir' }} el año?"
                                        data-param="/api/years/{{ $year->id }}/close-or-open"
                                        class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        {{ $year->status ? 'Cerrar' : 'Abrir' }} año
                                    </button>
                                @endif
                                @if ($cuser->has('users:questionnaire-templates:edit') || $cuser->isDev())
                                    <button data-atitle="¿Eliminar año?"
                                        data-adescription="Todos los edas, evaluaciones, cuestionarios de este año serán eliminados. ¿Estás seguro de eliminar este año?"
                                        data-param="/api/years/{{ $year->id }}/delete"
                                        class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Eliminar año
                                    </button>
                                @endif
                            </div>

                            {{-- <a href="/edas/questionnaire-templates/{{ $template->id }}" class="absolute inset-0"></a>
                            @if ($template->use_for !== null)
                                <span class="text-sm text-nowrap bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                    {{ $template->use_for === 'collaborators' ? 'Colaboradores' : 'Supervisores' }}
                                </span>
                            @endif
                            <p>
                                {{ $template->questions->count() }} preguntas
                            </p>
                            <button class="rounded-full p-2 hover:bg-stone-200 relative transition-colors"
                                data-dropdown-toggle="dropdown-{{ $template->id }}">
                                svg'bx-dots-vertical-rounded', 'w-5 h-5')
                            </button>
                            <div id="dropdown-{{ $template->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('users:questionnaire-templates:edit') || $cuser->isDev())
                                    <button data-atitle="¿Usar como cuestionario para colaboradores?"
                                        data-adescription="Todos los colaboradores tendrán este cuestionario en sus edas."
                                        data-param="/api/questionnaire-templates/{{ $template->id }}/use/collaborators"
                                        class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Usar para colaboradores
                                    </button>
                                    <button data-atitle="¿Usar como cuestionario para supervisores?"
                                        data-adescription="Todos los supervisores tendrán este cuestionario en sus edas."
                                        data-param="/api/questionnaire-templates/{{ $template->id }}/use/supervisors"
                                        class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Usar para supervisores
                                    </button>
                                @endif
                            </div> --}}
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
    {{-- <div class="w-full flex flex-col h-full overflow-y-auto">
        <nav class="border-b mb-2 p-2 flex items-center gap-3">

            @if ($cuser->has('edas:years:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                    class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <span class="max-lg:hidden">Registar nuevo año</span>
                </button>

                <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                        <div class="flex items-center justify-between p-3 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Registrar año
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="dialog">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                        @include('components.users.auditory-card')
                        <form action="/api/years" method="POST" id="dialog-form" class="p-3 dinamic-form grid gap-4">
                            @include('modules.edas.years.form', [
                                'year' => null,
                            ])
                        </form>
                        <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                            <button form="dialog-form" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                Guardar</button>
                            <button id="button-close-scheldule-modal" data-modal-hide="dialog" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            @endif

            <div>
                <input value="{{ request()->get('q') }}" type="search"
                    class="p-1 dinamic-search px-3 rounded-lg border-neutral-300" placeholder="Buscar...">
            </div>
        </nav>
        <h2 class="py-3 font-semibold tracking-tight text-lg px-1">
            Gestión de años de edas.
        </h2>
        <div class="overflow-auto flex-grow">
            @if ($cuser->has('edas:years:show') || $cuser->isDev())
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                            <th>Año</th>
                            <th class="text-center">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($years->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay nada por aquí
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($years as $year)
                                <tr
                                    class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                    <td>
                                        <div class="flex items-center gap-4">
                                            @if ($cuser->has('edas:years:edit'))
                                                <button class="absolute inset-0"
                                                    data-modal-target="dialog-{{ $year->id }}"
                                                    data-modal-toggle="dialog-{{ $year->id }}">
                                                </button>
                                                <div id="dialog-{{ $year->id }}" data-modal-backdrop="static"
                                                    tabindex="-1" aria-hidden="true"
                                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div
                                                        class="relative w-full max-w-lg max-h-full bg-white rounded-2xl shadow">
                                                        <div
                                                            class="flex items-center justify-between p-3 border-b rounded-t">
                                                            <h3 class="text-lg font-semibold text-gray-900">
                                                                Editar año
                                                            </h3>
                                                            <button type="button"
                                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                                data-modal-hide="dialog-{{ $year->id }}">
                                                                <svg class="w-3 h-3" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        @include('components.users.auditory-card')
                                                        <form action="/api/years/{{ $year->id }}" method="POST"
                                                            id="dialog-{{ $year->id }}-form"
                                                            class="p-3 dinamic-form grid gap-4">
                                                            @include('modules.edas.years.form', [
                                                                'year' => $year,
                                                            ])
                                                        </form>
                                                        <div
                                                            class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                            <button form="dialog-{{ $year->id }}-form" type="submit"
                                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                                Guardar</button>
                                                            <button id="button-close-scheldule-modal"
                                                                data-modal-hide="dialog-{{ $year->id }}" type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <p class="text-sm font-normal flex-grow text-nowrap">
                                                <span class="text-base block font-semibold">
                                                    {{ $year->name }}
                                                </span>
                                            </p>

                                            <button data-dropdown-toggle="dropdown-year-{{ $year->id }}"
                                                class="group-hover:opacity-100 relative opacity-0 hover:bg-stone-200/80 rounded-md p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-ellipsis">
                                                    <circle cx="12" cy="12" r="1" />
                                                    <circle cx="19" cy="12" r="1" />
                                                    <circle cx="5" cy="12" r="1" />
                                                </svg>
                                            </button>

                                            <div id="dropdown-year-{{ $year->id }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                                <button data-alertvariant="warning"
                                                    data-atitle="{{ $year->status ? 'Cerrar' : 'Abrir' }} año"
                                                    data-adescription="¿Estas seguro de {{ $year->status ? 'cerrar' : 'abrir' }} el año?"
                                                    data-param="/api/years/{{ $year->status ? 'close' : 'open' }}/{{ $year->id }}"
                                                    class="p-2 text-left dinamic-alert hover:bg-stone-100 w-full block rounded-md text-red-500 hover:bg-gray-10">
                                                    {{ $year->status ? 'Cerrar' : 'Abrir' }} eda
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="p-1 w-fit mx-auto font-medium text-sm rounded-md px-2 {{ $year->status ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                            {{ $year->status ? 'Abierto' : 'Cerrado' }}
                                        </div>
                                    <td>
                                    <td>
                                        <p class="text-nowrap"
                                            title="Registrado por Ver perfil de {{ $year->createdBy->last_name }}, {{ $year->createdBy->first_name }}">
                                            {{ \Carbon\Carbon::parse($year->updated_at)->isoFormat('LL') }}
                                        </p>
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
        <footer class="px-5 pt-4">
            {!! $years->links() !!}
        </footer>
    </div> --}}
@endsection
