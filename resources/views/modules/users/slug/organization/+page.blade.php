@extends('modules.users.slug.+layout')

@section('title', 'Organización: ' . $user->first_name . ', ' . $user->last_name)


@section('layout.users.slug')
    <div class="p-20 space-y-4 flex flex-col h-full items-center w-full">
        <h1 class="font-serif text-2xl tracking-tight">
            Modulo de organización
        </h1>
    </div>
@endsection
