@extends('layouts.app')

@section('content')
    <div class="grid place-content-center p-4 text-black w-full flex-grow">
        <h1 class="text-md max-w-[20ch] text-center">
            <div class="w-28 rounded-full overflow-hidden mx-auto border aspect-square">
                <img src={{ $current_user->profile }} class="w-full h-full object-cover" alt="">
            </div>
            Hola, <b class="text-indigo-700">{{ $current_user->first_name }}</b> Bienvenido al sistema
        </h1>
    </div>
@endsection
