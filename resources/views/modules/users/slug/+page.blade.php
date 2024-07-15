@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)


@section('layout.users.slug')
    <div class="p-4 space-y-4 flex h-full flex-col">

        <div class="flex-grow w-full overflow-y-auto ">
            <form id="edit-user-form" class="grid gap-4 px-1 w-full dinamic-form" method="POST" role="form"
                action="/api/users/{{ $user->id }}">
                @include('modules.users.form', [
                    'user' => $user,
                ])
            </form>
        </div>

        <div class="pt-4 border-t">
            <button type="submit" form="edit-user-form"
                class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                Guardar cambios
            </button>
        </div>
    </div>
@endsection
