@extends('layouts.eda-user')

@section('title', 'Cuestionario anual de EDAs')

@section('content-eda-user')

    <div class="h-full flex flex-col mt-3 bg-white overflow-auto rounded-xl">
        <h1>Cuestionario anual</h1>
        {{-- <input type="hidden" id="input-hidden-id-evaluation" value="{{ $evaluation->id }}"> --}}

        {{-- @if ($hasSelfQualification)
            <span id="has-self-quaification"></span>
        @endif

        @if ($hasAverage)
            <span id="has-average"></span>
        @endif

         --}}
    </div>
@endsection
