@extends('modules.users.slug.+layout')

@section('title', 'Asistencias: ' . $user->first_name . ', ' . $user->last_name)


@section('layout.users.slug')
    <div class="p-4 space-y-4 flex h-full flex-col">
        Asistencias
    </div>
@endsection
