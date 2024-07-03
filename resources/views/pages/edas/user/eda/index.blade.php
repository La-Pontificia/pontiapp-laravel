@extends('layouts.eda-user')

@section('title', 'Eda: ' . $year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@php
    $isPosibleCreateEda = $current_user->hasPrivilege('create_edas') && $year->status;
@endphp

@section('content-eda-user')
    @if ($eda)
        <div class="p-4 h-full flex flex-col">
            <div class="px-2">
                <h1 class="text-lg font-semibold">Completa todas las tareas asignadas.</h1>
                <p class=" font-normal text-sm">Eda registrado el
                    {{ \Carbon\Carbon::parse($eda->created_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $eda->createdBy->first_name }} {{ $eda->createdBy->last_name }}"
                        href="/profile/{{ $eda->createdBy->id }}" class="hover:underline text-blue-600">
                        {{ $eda->createdBy->first_name }}
                        {{ $eda->createdBy->last_name }}.
                    </a>
                </p>
            </div>
            <div class="p-2 flex relative">
                <div class="px-4">
                    <div class="bg-neutral-300 h-full w-px block"></div>
                </div>
                <div class="py-5 w-[500px]  space-y-5">
                    <a href="{{ route('edas.user.eda.goals', ['year' => $year->id, 'id_user' => $user->id]) }}"
                        class="border p-2 gap-2 items-center rounded-xl bg-white hover:border-rose-500 w-full flex">
                        <div class="p-4 text-white rounded-md bg-gradient-to-br from-rose-400 to-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-notebook">
                                <path d="M2 6h4" />
                                <path d="M2 10h4" />
                                <path d="M2 14h4" />
                                <path d="M2 18h4" />
                                <rect width="16" height="20" x="4" y="2" rx="2" />
                                <path d="M16 2v20" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h2 class="font-semibold">Objetivos</h2>
                            <p class="opacity-70 text-sm">Completa los objetivos asignados.</p>
                        </div>
                        <div class="space-y-1 text-xs flex flex-col items-end">
                            @if ($eda->sent)
                                <span
                                    class="block p-1 px-2 rounded-md bg-green-200 text-green-800 font-semibold">Enviado</span>
                            @endif
                            @if ($eda->approved)
                                <span
                                    class="block p-1 px-2 rounded-md bg-blue-200 text-blue-800 font-semibold">Aprovado</span>
                            @endif
                        </div>
                        <span
                            class="absolute w-5 rounded-full border-4 block aspect-square left-3.5 border-blue-700 bg-blue-100"></span>
                    </a>
                    <span class="block pt-10 font-semibold">Evaluaciones</span>
                    @foreach ($evaluations as $index => $evaluation)
                        @php
                            $prevEvaluation = $evaluations[$index - 1] ?? (object) ['closed' => true];
                        @endphp
                        <a href="{{ route('edas.user.eda.evaluation', ['year' => $year->id, 'id_user' => $user->id, 'id_evaluation' => $evaluation->id]) }}"
                            {{ !$eda->approved || !$prevEvaluation->closed ? 'data-hidden' : '' }}
                            class="border data-[hidden]:opacity-30 data-[hidden]:pointer-events-none p-2 gap-2 items-center rounded-xl bg-white hover:border-blue-500 w-full flex">
                            <div class="p-4 text-white rounded-md bg-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-text-select">
                                    <path d="M5 3a2 2 0 0 0-2 2" />
                                    <path d="M19 3a2 2 0 0 1 2 2" />
                                    <path d="M21 19a2 2 0 0 1-2 2" />
                                    <path d="M5 21a2 2 0 0 1-2-2" />
                                    <path d="M9 3h1" />
                                    <path d="M9 21h1" />
                                    <path d="M14 3h1" />
                                    <path d="M14 21h1" />
                                    <path d="M3 9v1" />
                                    <path d="M21 9v1" />
                                    <path d="M3 14v1" />
                                    <path d="M21 14v1" />
                                    <line x1="7" x2="15" y1="8" y2="8" />
                                    <line x1="7" x2="17" y1="12" y2="12" />
                                    <line x1="7" x2="13" y1="16" y2="16" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="font-semibold">Evaluacion N°{{ $evaluation->number }}</h2>
                                <p class="opacity-70 text-sm text-nowrap">Completa la evaluación asignada.</p>
                            </div>
                            <div class="text-xs flex-wrap justify-end flex gap-2 items-end">
                                @if ($evaluation->self_qualification)
                                    <span
                                        class="block p-1 px-2 rounded-md bg-green-200 text-green-800 font-semibold">Autocalificado</span>
                                @endif
                                @if ($evaluation->average)
                                    <span
                                        class="block p-1 px-2 rounded-md bg-blue-200 text-blue-800 font-semibold">Calificado</span>
                                @endif
                                @if ($evaluation->closed)
                                    <span
                                        class="block p-1 px-2 rounded-md bg-red-200 text-red-800 font-semibold">Cerrado</span>
                                @endif
                            </div>
                            <span {{ !$eda->approved || !$prevEvaluation->closed ? 'data-hidden' : '' }}
                                class="absolute w-5 rounded-full data-[hidden]:grayscale border-4 block aspect-square left-3.5 border-blue-700 bg-blue-100"></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
