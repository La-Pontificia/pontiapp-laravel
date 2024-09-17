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

    $times = [
        [
            'value' => '05:00',
            'label' => '05:00 AM',
        ],
        [
            'value' => '05:30',
            'label' => '05:30 AM',
        ],
        [
            'value' => '06:00',
            'label' => '06:00 AM',
        ],
        [
            'value' => '06:30',
            'label' => '06:30 AM',
        ],
        [
            'value' => '07:00',
            'label' => '07:00 AM',
        ],
        [
            'value' => '07:30',
            'label' => '07:30 AM',
        ],
        [
            'value' => '08:00',
            'label' => '08:00 AM',
        ],
        [
            'value' => '08:30',
            'label' => '08:30 AM',
        ],
        [
            'value' => '09:00',
            'label' => '09:00 AM',
        ],
        [
            'value' => '09:30',
            'label' => '09:30 AM',
        ],
        [
            'value' => '10:00',
            'label' => '10:00 AM',
        ],
        [
            'value' => '10:30',
            'label' => '10:30 AM',
        ],
        [
            'value' => '11:00',
            'label' => '11:00 AM',
        ],
        [
            'value' => '11:30',
            'label' => '11:30 AM',
        ],
        [
            'value' => '12:00',
            'label' => '12:00 PM',
        ],
        [
            'value' => '12:30',
            'label' => '12:30 PM',
        ],
        [
            'value' => '13:00',
            'label' => '01:00 PM',
        ],
        [
            'value' => '13:30',
            'label' => '01:30 PM',
        ],
        [
            'value' => '14:00',
            'label' => '02:00 PM',
        ],
        [
            'value' => '14:30',
            'label' => '02:30 PM',
        ],
        [
            'value' => '15:00',
            'label' => '03:00 PM',
        ],
        [
            'value' => '15:30',
            'label' => '03:30 PM',
        ],
        [
            'value' => '16:00',
            'label' => '04:00 PM',
        ],
        [
            'value' => '16:30',
            'label' => '04:30 PM',
        ],
        [
            'value' => '17:00',
            'label' => '05:00 PM',
        ],
        [
            'value' => '17:30',
            'label' => '05:30 PM',
        ],
        [
            'value' => '18:00',
            'label' => '06:00 PM',
        ],
        [
            'value' => '18:30',
            'label' => '06:30 PM',
        ],
        [
            'value' => '19:00',
            'label' => '07:00 PM',
        ],
        [
            'value' => '19:30',
            'label' => '07:30 PM',
        ],
        [
            'value' => '20:00',
            'label' => '08:00 PM',
        ],
        [
            'value' => '20:30',
            'label' => '08:30 PM',
        ],
        [
            'value' => '21:00',
            'label' => '09:00 PM',
        ],
        [
            'value' => '21:30',
            'label' => '09:30 PM',
        ],
        [
            'value' => '22:00',
            'label' => '10:00 PM',
        ],
        [
            'value' => '22:30',
            'label' => '10:30 PM',
        ],
        [
            'value' => '23:00',
            'label' => '11:00 PM',
        ],
    ];

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
