@php

    $daysJson = isset($schedule) ? $schedule->days : ['1'];
    $startDate = isset($schedule) ? date('d/m/Y', strtotime($schedule->start_date)) : '2020-01-01';
    $endDate = isset($schedule) ? date('d/m/Y', strtotime($schedule->end_date)) : '2030-01-01';

    $from = isset($schedule) ? date('H:i', strtotime($schedule->from)) : null;
    $from_start = isset($schedule) ? date('H:i', strtotime($schedule->from_start)) : null;
    $from_end = isset($schedule) ? date('H:i', strtotime($schedule->from_end)) : null;

    $to = isset($schedule) ? date('H:i', strtotime($schedule->to)) : null;
    $to_start = isset($schedule) ? date('H:i', strtotime($schedule->to_start)) : null;
    $to_end = isset($schedule) ? date('H:i', strtotime($schedule->to_end)) : null;

    $user_id = isset($user) ? $user->id : null;

    $background = isset($schedule) ? $schedule->background : '#52525b';

    $times = [];
    for ($hour = 5; $hour <= 23; $hour++) {
        for ($minute = 0; $minute < 60; $minute += 15) {
            $time = $hour . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT);
            $label = ($hour < 12
                    ? $hour . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ' AM'
                    : $hour > 12)
                ? $hour - 12 . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ' PM'
                : '12:' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ' PM';
            $times[] = [
                'value' => $time,
                'label' => $label,
            ];
        }
    }

@endphp



<div class="flex items-center gap-2">
    @if ($user_id)
        <input type="hidden" name="user_id" value="{{ $user_id }}">
    @endif
    <fluent-text-field name="title" value="{{ $schedule->title ?? 'Horario laboral' }}" placeholder="Título (Opcional)"
        class="outline-none">Título: </fluent-text-field>
</div>

<div class="grid-cols-2 hidden gap-5">
    <label class="label">
        <span>Inicia a partir de la fecha:</span>
        <input value="{{ $startDate }}" type="date" placeholder="Nombre" name="start_date">
    </label>
    <label class="label">
        <span>Finaliza en la fecha:</span>
        <input value="{{ $endDate }}" type="date" name="end_date">
    </label>
</div>

<div>
    <span class="block pb-2 font-semibold text-xs opacity-80">Días de la semana:</span>
    <div class="flex items-center gap-5">
        @foreach ($days as $day)
            <label title="{{ $day['name'] }}" class="flex items-center gap-1">
                @php
                    $checked = $daysJson && in_array($day['key'], $daysJson);
                @endphp
                <input data-nostyles {{ $checked ? 'checked' : '' }} class=" peer" type="checkbox" name="days[]"
                    value="{{ $day['key'] }}">
                <div class="">
                    {{ $day['name'] }}</div>
            </label>
        @endforeach
    </div>
</div>

<div class="grid border-y grid-cols-2 py-3 gap-4">
    <label class="label">
        <span>Entrada:</span>
        <select name="from">
            @foreach ($times as $time)
                <option {{ $from === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                    {{ $time['label'] }}</option>
            @endforeach
        </select>
    </label>
    <div class="w-full">
        <label class="label">
            <span>Permite marcar entrada desde:</span>
            <select name="from_start">
                @foreach ($times as $time)
                    <option {{ $from_start === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                        {{ $time['label'] }}</option>
                @endforeach
            </select>
        </label>
        <label class="label">
            <span>Permite marcar entrada hasta:</span>
            <select name="from_end">
                @foreach ($times as $time)
                    <option {{ $from_end === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                        {{ $time['label'] }}</option>
                @endforeach
            </select>
        </label>
    </div>
</div>

<div class="grid grid-cols-2 py-3 gap-4">
    <label class="label">
        <span>Salida:</span>
        <select name="to">
            @foreach ($times as $time)
                <option {{ $to === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                    {{ $time['label'] }}</option>
            @endforeach
        </select>
    </label>
    <div class="w-full">
        <label class="label">
            <span>Permite marcar salida desde:</span>
            <select name="to_start">
                @foreach ($times as $time)
                    <option {{ $to_start === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                        {{ $time['label'] }}</option>
                @endforeach
            </select>
        </label>
        <label class="label">
            <span>Permite marcar salida hasta:</span>
            <select name="to_end">
                @foreach ($times as $time)
                    <option {{ $to_end === $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                        {{ $time['label'] }}</option>
                @endforeach
            </select>
        </label>
    </div>
</div>
