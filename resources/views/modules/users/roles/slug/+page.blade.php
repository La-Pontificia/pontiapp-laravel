@extends('modules.users.+layout')

@section('title', 'Editar rol: ' . $role->title)

@php
    $privileges = $role->privileges;
@endphp

@section('layout.users')
    <div class="w-full h-full">
        <form role="form" action="/api/users/roles/{{ $role->id }}" method="POST" id="role-form"
            class="p-3 dinamic-form flex flex-col h-full gap-3" enctype="multipart/form-data">
            <div class="flex-grow flex flex-col overflow-y-auto">
                @include('modules.users.roles.form', ['role' => $role])
            </div>
            <div class="border-t pt-4">
                <button form="role-form" type="submit"
                    class="bg-blue-700 w-fit hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
@endsection
