@php

    $carbon = new \Carbon\Carbon();
    $days = [
        1 => ['key' => '1', 'name' => 'Lun'],
        2 => ['key' => '2', 'name' => 'Mar'],
        3 => ['key' => '3', 'name' => 'Mié'],
        4 => ['key' => '4', 'name' => 'Jue'],
        5 => ['key' => '5', 'name' => 'Vie'],
        6 => ['key' => '6', 'name' => 'Sáb'],
        7 => ['key' => '7', 'name' => 'Dom'],
    ];

    $selectedDays = isset($schedule) ? $schedule->days : ['1'];
    $selectedTerminal = isset($schedule) ? $schedule->terminal_id : null;
    $selectedFrom = isset($schedule) ? $carbon::parse($schedule->from)->format('H:s') : '08:00';
    $selectedTo = isset($schedule) ? $carbon::parse($schedule->to)->format('H:s') : '13:00';
    $selectedStartDate = isset($schedule) ? $carbon::parse($schedule->start_date)->format('Y-m-d') : '';

    $times = [];
    $amPmLabels = ['AM', 'PM'];

    for ($hour = 5; $hour <= 23; $hour++) {
        for ($minute = 0; $minute < 60; $minute += 15) {
            $amPmIndex = $hour >= 12 ? 1 : 0;
            $hourDisplay = $hour % 12 == 0 ? 12 : $hour % 12;
            $timeValue = sprintf('%02d:%02d', $hour, $minute);
            $timeLabel = sprintf('%02d:%02d %s', $hourDisplay, $minute, $amPmLabels[$amPmIndex]);

            $times[] = [
                'value' => $timeValue,
                'label' => $timeLabel,
            ];
        }
    }

@endphp

<div class="grid-cols-2 gap-5">
    <label class="label">
        <span>Inicia o inició a partir de la fecha</span>
        <input type="date" value="{{ $selectedStartDate }}" required placeholder="Nombre" name="start_date">
    </label>
</div>
<div>
    <span class="block pb-2 font-semibold text-xs opacity-80">Días de la
        semana que se aplicará el horario:
    </span>
    <div class="grid grid-cols-7 gap-2">
        @foreach ($days as $key => $day)
            <label title="{{ $day['name'] }}" class="flex items-center gap-1">
                @php
                    $checked = in_array($key, $selectedDays);
                @endphp
                <input {{ $checked ? 'checked' : '' }} class=" peer" type="checkbox" name="day[]"
                    value="{{ $key }}">
                <div class="">
                    {{ $day['name'] }}</div>
            </label>
        @endforeach
    </div>
</div>
<div class="border-t grid grid-cols-2 gap-3">
    <label class="label">
        <span>Entrada:</span>
        <select name="from">
            @foreach ($times as $time)
                <option {{ $selectedFrom == $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                    {{ $time['label'] }}</option>
            @endforeach
        </select>
    </label>
    <label class="label">
        <span>Salida:</span>
        <select class="times-select" name="to">
            @foreach ($times as $time)
                <option {{ $selectedTo == $time['value'] ? 'selected' : '' }} value="{{ $time['value'] }}">
                    {{ $time['label'] }}</option>
            @endforeach
        </select>
    </label>
</div>

<div class="border-t">
    <label class="label">
        <span>Terminal de asistencia:</span>
        <select class="terminal-select" name="terminal">
            @foreach ($terminals as $terminal)
                <option {{ $selectedTerminal == $terminal->id ? 'selected' : '' }} value="{{ $terminal->id }}">
                    {{ $terminal->name }}</option>
            @endforeach
        </select>
    </label>
</div>
