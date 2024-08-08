@php

    $daysJson = isset($schedule) ? json_decode($schedule->days) : ['1'];
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

@if ($user_id)
    <input type="hidden" name="user_id" value="{{ $user_id }}">
@endif

<div class="flex items-center gap-2">
    <input value="{{ $schedule->title ?? 'Horario laboral' }}" autofocus value="Horario laboral" type="text"
        placeholder="Título (Opcional)" name="title">
    <input data-notstyles type="color" value="{{ $background }}" name="background"
        class="w-9 h-9 aspect-square rounded-lg">
</div>
<div class="flex items-center gap-5">
    <div class="flex flex-col">
        <div class="text-sm opacity-60 font-semibold">Inicia:</div>
        <input value="{{ $startDate }}" required style="width: 170px" type="date" placeholder="Nombre"
            name="start_date">
    </div>
    <div class="flex flex-col">
        <div class="text-sm opacity-60 font-semibold">Finaliza:</div>
        <input value="{{ $endDate }}" style="width: 170px" type="date" name="end_date">
    </div>
</div>
<div>
    <div class="p-1">Días de la semana:</div>
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
<div class="flex border-y py-3 gap-2">
    <div class="flex flex-col w-full">
        <div class="text-sm opacity-60 font-semibold">Entrada:</div>
        <input value="{{ $from }}" min="05:00" max="23:00" required type="time"
            value="05:00"name="from" class="w-full">
    </div>
    <div class="w-full">
        <div class="flex flex-col">
            <div class="text-sm opacity-60 font-semibold">Permite marcar entrada desde:</div>
            <input value="{{ $from_start }}" min="04:00" max="24:00" required type="time" name="from_start"
                class="w-full">
        </div>
        <div class="flex flex-col">
            <div class="text-sm opacity-60 font-semibold">Permite marcar entrada hasta:</div>
            <input value="{{ $from_end }}" min="04:00" max="24:00" required type="time" name="from_end"
                class="w-full">
        </div>
    </div>
</div>
<div class="flex border-y py-3  gap-2">
    <div class="flex flex-col w-full">
        <div class="text-sm opacity-60 font-semibold">Salida:</div>
        <input value="{{ $to }}" min="05:00" max="23:00" required type="time" name="to"
            class="w-full">
    </div>
    <div class="w-full">
        <div class="flex flex-col">
            <div class="text-sm opacity-60 font-semibold">Permite marcar salida desde:</div>
            <input value="{{ $to_start }}" min="04:00" max="24:00" required type="time" name="to_start"
                class="w-full">
        </div>
        <div class="flex flex-col">
            <div class="text-sm opacity-60 font-semibold">Permite marcar salida hasta:</div>
            <input value="{{ $to_end }}" min="04:00" max="24:00" required type="time" name="to_end"
                class="w-full">
        </div>
    </div>
</div>
