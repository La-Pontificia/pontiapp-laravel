@extends('modules.users.+layout')

@section('title', 'Registrar nuevo usuario')

@section('layout.users')
    @if ($current_user->hasPrivilege('users:create'))
        <div class="text-black w-full flex-grow flex flex-col overflow-y-auto">
            <div class="flex items-center justify-between p-4">
                <button onclick="window.history.back()" class="text-lg flex gap-2 items-center font-semibold text-gray-900 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    Regitrar nuevo usuario
                </button>
            </div>
            <div class="p-5 flex-grow w-full overflow-y-auto ">
                <form class="grid gap-4 w-full" role="form" id="reate-user-form">
                    @include('modules.users.form', [
                        'user' => null,
                    ])
                </form>
            </div>
            <div class="p-3 border-t border-neutral-300">
                <div class="max-w-2xl mx-auto flex gap-2">
                    <button type="submit" form="reate-user-form"
                        class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                        Registrar
                    </button>
                    <button onclick="window.history.back()" type="button"
                        class="bg-white hover:shadow-md border text-black flex items-center rounded-xl p-2.5 gap-1 font-semibold px-3">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @else
        @include('commons.+403')
    @endif
@endsection
