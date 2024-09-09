@extends('modules.edas.slug.+layout')

@php
    $edauser = isset($eda) ? $eda->user : $user;
@endphp

@section('title', 'Eda: ' . $current_year->name . ' - ' . $edauser->first_name . ' ' . $edauser->last_name)

@section('layout.edas.slug')
    @if ($eda)
        <div class="h-full flex flex-col space-y-3 justify-center items-center">
            <div class="text-center">
                <h1 class="text-sm font-semibold">Completa todas las tareas asignadas.</h1>
                <p class=" font-normal text-xs">Eda registrada el
                    {{ \Carbon\Carbon::parse($eda->created_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $eda->createdBy->first_name }} {{ $eda->createdBy->last_name }}"
                        href="/profile/{{ $eda->createdBy->id }}" class="hover:underline text-blue-600">
                        {{ $eda->createdBy->names() }}
                    </a>
                </p>
            </div>
            <div class="flex gap-3 justify-center max-w-5xl flex-wrap [&>a]:max-w-[250px]">
                <a href="/edas/{{ $edauser->id }}/eda/{{ $current_year->id }}/goals"
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl">
                    <img src="/pen.png" class="w-6 m-3" alt="">
                    <div class="flex-grow">
                        <h2 class="font-semibold text-sm">Objetivos</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">Agrega sus objetivos y envia para su previa
                            aprobación.
                        </p>
                    </div>
                    @if ($eda->approved)
                        <div class="absolute top-2 right-2">
                            @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-blue-700')
                        </div>
                    @endif
                </a>

                @foreach ($eda->evaluations as $index => $evaluation)
                    @php
                        $prevEvaluation = $eda->evaluations[$index - 1] ?? (object) ['closed' => true];
                        $active = $eda->approved && $prevEvaluation->closed;
                    @endphp

                    <a href="{{ $active ? "/edas/$edauser->id/eda/$current_year->id/evaluation/$evaluation->id" : '' }}"
                        {{ $active ? '' : 'data-disabled' }}
                        class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl data-[disabled]:grayscale data-[disabled]:opacity-50 data-[disabled]:pointer-events-none data-[disabled]:select-none">
                        <img src="/sheet-pen.png" class="w-6 m-3" alt="">
                        <div class="flex-grow text-sm">
                            <h2 class="font-semibold">Evaluacion N° {{ $evaluation->number }}</h2>
                            <p class="opacity-70 text-xs text-ellipsis line-clamp-2">Completa la evaluación asignada.
                            </p>
                        </div>

                        @if ($evaluation->closed)
                            <div class="absolute top-2 right-2">
                                @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-blue-700')
                            </div>
                        @endif
                    </a>
                @endforeach

                @php
                    $lastEvaluation = $eda->evaluations->last();
                @endphp

                <a href="{{ $lastEvaluation->closed ? "/edas/$edauser->id/eda/$current_year->id/ending" : '' }} "
                    {{ $lastEvaluation->closed ? '' : 'data-disabled' }}
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl data-[disabled]:grayscale data-[disabled]:opacity-50 data-[disabled]:pointer-events-none data-[disabled]:select-none">
                    <img src="/sheets.png" class="w-6 m-3" alt="">
                    <div class="flex-grow text-sm">
                        <h2 class="font-semibold">{{ $eda->closed ? 'Resumen del Eda' : 'Finalización del Eda.' }}</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">
                            Revisa las notas finales y cierra el EDA.
                        </p>
                    </div>

                    @if ($eda->closed)
                        <div class="absolute top-2 right-2">
                            @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-blue-700')
                        </div>
                    @endif
                </a>

                <a href="{{ $eda->closed ? "/edas/$edauser->id/eda/$current_year->id/questionnaires" : '' }}"
                    {{ $eda->closed ? '' : 'data-disabled' }}
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl data-[disabled]:grayscale data-[disabled]:opacity-50 data-[disabled]:pointer-events-none data-[disabled]:select-none">
                    <img src="/idea.png" class="w-6 m-3" alt="">
                    <div class="flex-grow">
                        <h2 class="font-semibold text-sm">Cuestionarios</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">
                            Responde a los cuestionario asignados por cada Eda. y visualiza los resultados de su
                            Supervisor o colaborador.
                        </p>
                    </div>

                    @if ($eda->supervisorQuestionnaire && $eda->collaboratorQuestionnaire)
                        <div class="absolute top-2 right-2">
                            @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-blue-700')
                        </div>
                    @endif

                </a>

            </div>

            @if ($eda->closed)
                <p class="text-xs text-neutral-400 mt-5">
                    EDA cerrado el {{ \Carbon\Carbon::parse($eda->closed)->isoFormat('LL') }} por
                    {{ $eda->closedBy->names() }}
                </p>
            @endif
        </div>
    @endif
@endsection
