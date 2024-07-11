@extends('layouts.app')

@section('title', 'Editar usuario: ' . $user->first_name . ' ' . $user->last_name)

@php
    $domains = ['elp.edu.pe', 'ilp.edu.pe', 'gmail.com'];
    $has_assign_email = $current_user->hasPrivilege('assign_email');

@endphp

@section('content')

    @if ($has_assign_email)
        <!-- Assign email modal-->
        <div id="assign-email-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-2xl shadow">
                    <div class="flex items-center justify-between p-3 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Asignar correo
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="assign-email-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    @include('components.users.auditory-card')
                    <form method="POST" action="/api/emails/assign" role="form" id="assign-email-form"
                        class="dinamic-form" enctype="multipart/form-data">
                        <div class="p-3 grid gap-3">
                            <input type="hidden" value="{{ $user->id }}" name="id_user">
                            <div class="flex items-center gap-1">
                                <input required type="text" name="username" placeholder="Nombre de usuario"
                                    class="w-full">
                                <select style="width: 170px" required name="domain">
                                    @foreach ($domains as $domain)
                                        <option {{ $user && $domain === 'elp.edu.pe' ? 'selected' : '' }}
                                            value="{{ $domain }}">
                                            {{ '@' . $domain }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <textarea required placeholder="Descripción (Motivo)" name="reason" cols="20" rows="5"></textarea>
                        </div>
                    </form>

                    <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                        <button form="assign-email-form" type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                            Guardar</button>
                        <button data-modal-hide="assign-email-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($current_user->hasPrivilege('edit_users'))
        <div class="text-black w-full flex-grow flex flex-col overflow-y-auto">
            <div class="flex items-center justify-between p-4">
                <button onclick="window.history.back()"
                    class="text-lg flex gap-2 items-center font-semibold text-gray-900 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    {{ $user->last_name }}, {{ $user->first_name }}
                </button>
            </div>
            <div class="flex-grow w-full overflow-y-auto p-1">
                <form id="user-form" class="grid gap-4 w-full" role="form">
                    @include('components.users.form', [
                        'user' => $user,
                    ])
                </form>
                <div>
                    <div class="text-sm flex flex-col text-neutral-500 mt-4">
                        <span>Última actualización el
                            {{ $user->updated_at->translatedFormat('d \d\e F \d\e Y \a \l\a\s h:i A') }}
                            @if ($user->updated_by)
                                por <a href="#"
                                    class="text-blue-500 hover:underline">{{ $user->updatedBy->first_name . ' ' . $user->updatedBy->last_name }}</a>
                            @endif
                        </span>
                        <span>
                            Registrado el {{ $user->created_at->translatedFormat('d \d\e F \d\e Y \a \l\a\s h:i A') }}
                            @if ($user->created_by)
                                por <a href="#"
                                    class="text-blue-500 hover:underline">{{ $user->createdBy->first_name . ' ' . $user->createdBy->last_name }}</a>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-3 border-t border-neutral-300">
                <div class="max-w-2xl mx-auto flex gap-2">
                    <button id="create-user-button-submit" type="submit" id="button-submit-user" form="user-form"
                        class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-full p-2.5 gap-1 text-white text-sm font-semibold px-3">
                        Actualizar
                    </button>
                    <button onclick="window.history.back()" type="button" data-modal-hide="create-user-dialog"
                        class="bg-white hover:shadow-md border text-black flex items-center rounded-full p-2.5 gap-1 text-sm font-semibold px-3">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @else
        <div>
            <h1 class="text-black text-lg font-semibold">No tienes permisos para editar usuarios</h1>
        </div>
    @endif
@endsection
