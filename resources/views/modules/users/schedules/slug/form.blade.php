@php

    $daysJson = isset($schedule) ? $schedule->days : ['1'];
    $startDate = isset($schedule) ? date('Y-m-d', strtotime($schedule->start_date)) : null;
    $endDate = isset($schedule) ? date('Y-m-d', strtotime($schedule->end_date)) : null;

    $from = isset($schedule) ? date('H:i', strtotime($schedule->from)) : null;
    $from_start = isset($schedule) ? date('H:i', strtotime($schedule->from_start)) : null;
    $from_end = isset($schedule) ? date('H:i', strtotime($schedule->from_end)) : null;

    $to = isset($schedule) ? date('H:i', strtotime($schedule->to)) : null;
    $to_start = isset($schedule) ? date('H:i', strtotime($schedule->to_start)) : null;
    $to_end = isset($schedule) ? date('H:i', strtotime($schedule->to_end)) : null;

    $user_id = isset($user) ? $user->id : null;

    $background = isset($schedule) ? $schedule->background : '#52525b';

@endphp



<div class="flex items-center gap-2">
    <label class="label">
        <span>Nombre</span>
        <input value="{{ $schedule->title ?? 'Horario laboral' }}" autofocus value="Horario laboral" type="text"
            placeholder="Título (Opcional)" name="title">
    </label>

    <label class="label">
        <span>Color</span>
        <input type="color" value="{{ $background }}" name="background" class="w-9 h-9 p-0 aspect-square rounded-lg">
    </label>

</div>

<div class="grid grid-cols-2 gap-5">
    <label class="label">
        <span>Inicia a partir de la fecha:</span>
        <input value="{{ $startDate }}" required type="date" placeholder="Nombre" name="start_date">
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
        <input value="{{ $from }}" min="05:00" max="23:00" required type="time"
            value="05:00"name="from" class="w-full">
    </label>
    <div class="w-full">
        <label class="label">
            <span>Permite marcar entrada desde:</span>
            <input value="{{ $from_start }}" min="04:00" max="24:00" required type="time" name="from_start"
                class="w-full">
        </label>
        <label class="label">
            <span>Permite marcar entrada hasta:</span>
            <input value="{{ $from_end }}" min="04:00" max="24:00" required type="time" name="from_end"
                class="w-full">
        </label>
    </div>
</div>

<div class="grid grid-cols-2 py-3 gap-4">
    <label class="label">
        <span>Salida:</span>
        <input value="{{ $to }}" min="05:00" max="23:00" required type="time" name="to"
            class="w-full">
    </label>
    <div class="w-full">
        <label class="label">
            <span>Permite marcar salida desde:</span>
            <input value="{{ $to_start }}" min="04:00" max="24:00" required type="time" name="to_start"
                class="w-full">
        </label>
        <label class="label">
            <span>Permite marcar salida hasta:</span>
            <input value="{{ $to_end }}" min="04:00" max="24:00" required type="time" name="to_end"
                class="w-full">
        </label>
    </div>
</div>
