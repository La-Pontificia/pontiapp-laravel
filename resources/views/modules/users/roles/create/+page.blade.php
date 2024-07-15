@extends('modules.users.+layout')

@section('title', 'Registrar nuevo rol de usuario')


@section('layout.users')
    <div class="w-full h-full">
        <form action="/api/users/roles" role="form" id="role-form" method="POST" class="p-3 flex h-full flex-col gap-3"
            enctype="multipart/form-data">
            <div class="flex-grow flex flex-col overflow-y-auto">
                @include('modules.users.roles.form', ['role' => null])
            </div>
            <div class="border-t pt-4">
                <button type="submit" form="role-form"
                    class="bg-blue-700 w-fit hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                    Registrar
                </button>
            </div>
        </form>
    </div>
@endsection
