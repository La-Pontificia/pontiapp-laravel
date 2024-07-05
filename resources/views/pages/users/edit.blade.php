@extends('layouts.app')

@section('title', 'Editar usuario: ' . $user->first_name . ' ' . $user->last_name)


@section('content')
    @if ($current_user->hasPrivilege('edit_users'))
        <div class="text-black w-full flex-grow flex flex-col overflow-y-auto">
            <div class="flex items-center justify-between p-4">
                <button onclick="window.history.back()" class="text-lg flex gap-2 items-center font-semibold text-gray-900 ">
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
                        'username' => explode('@', $user->email)[0],
                        'domain' => explode('@', $user->email)[1],
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
