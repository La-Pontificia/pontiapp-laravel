@extends('layouts.app')

@section('title', 'Mantenimiento: plantillas de encuestas')

@php
    $forList = [
        'collaborators' => 'Colaboradores',
        'supervisors' => 'Supervisores',
    ];
@endphp

@section('content')
    <div>
        <nav class="border-b p-2 flex gap-3">
            <a href="{{ route('templates.create') }}"
                class="bg-sky-600 px-4 hover:bg-sky-700 transition-colors text-white font-semibold p-2 text-sm rounded-md">
                Crear plantilla
            </a>
            <select class="dinamic-select bg-transparent p-1 border-transparent rounded-lg cursor-pointer" name="for">
                <option value="0">Todos</option>
                @foreach ($forList as $key => $value)
                    <option {{ request()->query('for') === $key ? 'selected' : '' }} value="{{ $key }}">
                        {{ $value }}</option>
                @endforeach
            </select>
        </nav>
        <div class="w-full overflow-y-auto">
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
                                    <a href="{{ route('templates.edit', ['id' => $template->id]) }}"
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
                                    <a href="{{ route('templates.edit', ['id' => $template->id]) }}"
                                        class="font-semibold text-sm hover:underline text-blue-600">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
