@extends('modules.users.+layout')

@section('title', 'Registrar nuevo usuario')

@section('layout.users')
    @if ($cuser->has('users:create') || $cuser->isDev())
        <div class="text-black w-full flex-grow flex flex-col overflow-y-auto">
            <div class="flex items-center border-b justify-between p-2">
                <button onclick="window.history.back()" class="flex gap-2 items-center text-gray-900 ">
                    @svg('fluentui-arrow-left-20', 'w-5 h-5')
                    Registrar nuevo usuario
                </button>
            </div>
            <div class="p-5 flex-grow mt-2 w-full overflow-y-auto ">
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
        @include('+403', [
            'message' => 'No tienes permisos para crear usuarios.',
        ])
    @endif
@endsection
