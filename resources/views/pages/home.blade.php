@extends('layouts.app')

@section('content')
    <div class="grid place-content-center p-4 text-black w-full flex-grow">
        <h1 class="text-md max-w-[20ch] text-center">
            @include('commons.avatar', [
                'src' => $current_user->profile,
                'className' => 'w-28 mx-auto',
                'alt' => $current_user->first_name . ' ' . $current_user->last_name,
                'altClass' => 'text-3xl',
            ])
            Hola, <b class="text-blue-700">{{ $current_user->first_name }}</b> Bienvenido al sistema
        </h1>
    </div>
@endsection
