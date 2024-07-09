@extends('layouts.assists.user')

@section('content.assists.user')
    <div class="overflow-auto h-full rounded-2xl flex flex-col">
        <div class="bg-white rounded-xl p-2">
            <button>
                Crear horario
            </button>
        </div>
        <div class="w-full h-full" id="calendar">
        </div>
    </div>
@endsection
