@extends('modules.edas.slug.+layout')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $eda->user->first_name . ' ' . $eda->user->last_name)

@section('title_eda', 'Evaluación N°' . $evaluation->number)

@section('layout.edas.slug')

    @php

        // if current user is supervisor
        $isSupervisor = $current_user->id === $eda->user->supervisor_id;

        // if has self qualification
        $hasSelfQualify =
            ($cuser->has('edas:evaluations:self-qualify') &&
                !$evaluation->closed &&
                !$evaluation->self_qualification &&
                $isSupervisor) ||
            $cuser->isDev();

        // if has average evaluation
        $hasQualify =
            ($cuser->has('edas:evaluations:qualify') &&
                !$evaluation->closed &&
                $isSupervisor &&
                $evaluation->self_qualification &&
                !$evaluation->qualification) ||
            $cuser->isDev();

        // if has close evaluation
        $hasCloseEvaluation =
            ($cuser->has('edas:evaluations:close') &&
                !$evaluation->closed &&
                $evaluation->qualification &&
                $evaluation->self_qualification &&
                $isSupervisor) ||
            $cuser->isDev();

        $hasSendFeedback =
            ($cuser->has('edas:evaluations:feedback') && $evaluation->closed && $user->supervisor_id === $cuser->id) ||
            $cuser->isDev();
    @endphp
    <div class="h-full flex overflow-hidden flex-col pt-0 overflow-x-auto">

        @if ($hasSelfQualify || $hasQualify || $hasCloseEvaluation)
            <div class="flex items-center px-3 gap-2">
                <div class="flex-grow">
                </div>
                <div class="flex gap-2 items-center p-1 tracking-tight">

                    @if ($evaluation->closed)
                        <button data-id="{{ $evaluation->id }}"
                            id="{{ $evaluation->feedback_read_at ? 'feedback-open' : '' }}"
                            {{ $evaluation->feedback_read_at ? 'data-read' : '' }}
                            class="secondary"style="padding-block:3px;" data-modal-target="dialog" data-modal-toggle="dialog">
                            @svg('bx-wink-smile', 'w-5 h-5')
                            Feedback
                        </button>

                        @php
                            $feebackScore = [
                                [
                                    'key' => 1,
                                    'icon' => 'bx-sad',
                                    'checked' => false,
                                ],
                                [
                                    'key' => 2,
                                    'icon' => 'bx-meh',
                                    'checked' => false,
                                ],
                                [
                                    'key' => 3,
                                    'icon' => 'bx-smile',
                                    'checked' => true,
                                ],
                                [
                                    'key' => 4,
                                    'icon' => 'bx-happy',
                                    'checked' => false,
                                ],
                                [
                                    'key' => 5,
                                    'icon' => 'bx-happy-heart-eyes',
                                    'checked' => false,
                                ],
                            ];
                        @endphp

                        <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Feedback de la evaluación
                                </header>
                                @if ($evaluation->feedback_at && !$cuser->isDev())
                                    <div class=" body grid gap-4">
                                        <div>
                                            <p class="font-semibold">Score</p>
                                            @svg($feebackScore[$evaluation->feedback_score - 1]['icon'], 'w-8 h-8')
                                        </div>
                                        <div>
                                            <p class="font-semibold">Feedback</p>
                                            <p>{{ $evaluation->feedback ?? '-' }}</p>
                                        </div>
                                        <p>
                                            Enviado el {{ $evaluation->feedback_at->format('d/m/Y') }} por
                                            {{ $evaluation->feedbackBy->first_name }}
                                            {{ $evaluation->feedbackBy->last_name }}
                                        </p>
                                    </div>
                                    <footer>
                                        <button data-modal-hide="dialog" type="button" class="primary">Aceptar</button>
                                    </footer>
                                @elseif($hasSendFeedback)
                                    <form action="/api/evaluations/{{ $evaluation->id }}/feedback/send" method="POST"
                                        id="dialog-form" class="dinamic-form body grid gap-4">

                                        <div class="flex items-center justify-center">
                                            @foreach ($feebackScore as $score)
                                                <div class="flex flex-col items-center">
                                                    <input type="radio"
                                                        {{ !$evaluation->feedback_at && $score['checked'] ? 'checked' : '' }}
                                                        {{ $evaluation->feedback_at && $evaluation->feedback_score == $score['key'] ? 'checked' : '' }}
                                                        id="score-{{ $score['key'] }}" name="feedback_score"
                                                        value="{{ $score['key'] }}" class="peer" required>
                                                    <label for="score-{{ $score['key'] }}" class="p-1 rounded-full block">
                                                        @svg($score['icon'], 'w-8 h-8')
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <label class="label">
                                            <span>Descripción (Opcional)</span>
                                            <textarea name="feedback" cols="30" rows="7" class="w-full"
                                                placeholder="Escribe aquí tu feedback sobre esta evaluación.">{{ $evaluation->feedback }}</textarea>
                                        </label>
                                        @if ($evaluation->feedback_at)
                                            <p>
                                                Enviado el {{ $evaluation->feedback_at->format('d/m/Y') }} por
                                                {{ $evaluation->feedbackBy->first_name }}
                                                {{ $evaluation->feedbackBy->last_name }}
                                            </p>
                                        @endif
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                                        <button form="dialog-form" type="submit">
                                            Enviar</button>
                                    </footer>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($hasSelfQualify)
                        <button id="evaluation-self-qualify-button" data-id="{{ $evaluation->id }}"
                            class="bg-sky-600 shadow-sm shadow-sky-500/10 hover:bg-sky-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-full p-1 gap-1 text-sm px-3">
                            @svg('bx-plus', 'w-5 h-5')
                            Autocalificar
                        </button>
                    @endif
                    @if ($hasQualify)
                        <button data-id="{{ $evaluation->id }}" id="evaluation-qualify-button"
                            class="bg-violet-700 shadow-sm shadow-violet-500/10 data-[hidden]:hidden font-semibold justify-center hover:bg-violet-600 min-w-max flex items-center rounded-full p-1 gap-1 text-white text-sm px-3">
                            @svg('bxs-check-shield', 'w-5 h-5')
                            Calificiar
                        </button>
                    @endif

                    @if ($hasCloseEvaluation)
                        <button data-id="{{ $evaluation->id }}" id="evaluation-close-button"
                            class="bg-red-600 shadow-sm shadow-red-500/10 data-[hidden]:hidden font-semibold justify-center hover:bg-red-700 min-w-max flex items-center rounded-full p-1 gap-1 text-white text-sm px-3">
                            @svg('bx-x', 'w-5 h-5')
                            Cerrar
                        </button>
                    @endif
                </div>
            </div>
        @endif

        @if ($evaluation->closed)
            <span class="text-neutral-400 block text-center w-full p-3">Esta evaluación ha sido cerrada
                el {{ \Carbon\Carbon::parse($evaluation->closed_at)->isoFormat('LL') }} por
                {{ $evaluation->closedBy->first_name }}
                {{ $evaluation->closedBy->last_name }}.
            </span>
        @endif

        <div class="h-full flex-grow overflow-y-auto w-full">
            <table class="pt-3 text-sm w-full max-lg:grid-cols-1 px-1 py-1 gap-5">
                <thead class="border-b border-neutral-300">
                    <tr class="[&>th]:font-medium [&>th]:px-3 [&>th]:py-2">
                        <th>N°</th>
                        <th>Título</th>
                        <th class="min-w-[300px]">Descripción</th>
                        <th class="min-w-[300px]">Indicadores</th>
                        <th class="text-center">Porcentaje</th>
                        <th>Autocalificación</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody id="evaluations" class="divide-y divide-neutral-300">
                    @foreach ($evaluation->goalsEvaluations as $index => $eva)
                        <tr data-id="{{ $eva->id }}"
                            class="[&>td]:py-3 [&>td]:align-top hover:border-transparent hover:[&>td]shadow-md relative group [&>td]:px-2">
                            <td class="text-center goal-index whitespace-pre-line">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <p class="goal-title whitespace-pre-line">
                                    {{ $eva->goal->title }}
                                </p>
                            </td>
                            <td>
                                <p class="goal-description whitespace-pre-line">
                                    {{ $eva->goal->description }}
                                </p>
                            </td>
                            <td>
                                <p class="goal-indicators whitespace-pre-line">
                                    {{ $eva->goal->indicators }}
                                </p>
                            </td>
                            <td>
                                <p data-percentage="{{ $eva->goal->percentage }}"
                                    class="text-center goal-percentage percentage whitespace-pre-line">
                                    {{ $eva->goal->percentage }}%
                                </p>
                            </td>
                            <td>
                                <div class="flex justify-center whitespace-pre-line">
                                    @if ($hasSelfQualify)
                                        <select style="width: 60px" class="self-qualification">
                                            <option value="" selected> - </option>
                                            @foreach ([1, 2, 3, 4, 5] as $i)
                                                <option value="{{ $i }}"
                                                    {{ $i == $eva->self_qualification ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{ $eva->self_qualification ?? '-' }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center whitespace-pre-line">
                                    @if ($hasQualify)
                                        <select style="width: 60px" class="qualification">
                                            <option value="" selected>-</option>
                                            @foreach ([1, 2, 3, 4, 5] as $i)
                                                <option value="{{ $i }}"
                                                    {{ $i == $eva->qualification ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{ $eva->qualification ?? '-' }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <tr class="border-t border-neutral-300">
                        <td colspan="5" class="px-4 py-2">Totales</td>
                        <td class="text-center">
                            <p id="total-self-qualification" class="font-semibold text-blue-600">
                                {{ $evaluation->self_qualification ?? '-' }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p id="total-qualification" class="font-semibold text-blue-600">
                                {{ $evaluation->qualification ?? '-' }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="p-2 text-xs">
            @if ($evaluation->selfRatedBy)
                <span class="text-neutral-400">Autocaficado el
                    {{ \Carbon\Carbon::parse($evaluation->self_rated_at)->isoFormat('LL') }} por
                    {{ $evaluation->selfRatedBy->last_name }}, {{ $evaluation->selfRatedBy->first_name }}
                </span>
            @endif
            @if ($evaluation->qualifiedBy)
                <span class="text-neutral-400">y Aprobado
                    el {{ \Carbon\Carbon::parse($evaluation->qualified_at)->isoFormat('LL') }} por
                    {{ $evaluation->qualifiedBy->first_name }}
                    {{ $evaluation->qualifiedBy->last_name }}.
                </span>
            @endif
        </p>
    </div>
@endsection
