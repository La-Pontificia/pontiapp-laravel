@php

    $daysJson = isset($schedule) ? json_decode($schedule->days) : ['2'];
    $startDate = isset($schedule) ? date('Y-m-d', strtotime($schedule->start_date)) : null;
    $endDate = isset($schedule) ? date('Y-m-d', strtotime($schedule->end_date)) : null;
    $from = isset($schedule) ? date('H:i', strtotime($schedule->from)) : null;
    $to = isset($schedule) ? date('H:i', strtotime($schedule->to)) : null;
    $from_start = isset($schedule) ? date('H:i', strtotime($schedule->from_start)) : null;
    $from_end = isset($schedule) ? date('H:i', strtotime($schedule->from_end)) : null;
    $to_start = isset($schedule) ? date('H:i', strtotime($schedule->to_start)) : null;
    $to_end = isset($schedule) ? date('H:i', strtotime($schedule->to_end)) : null;
    $user_id = isset($user) ? $user->id : null;
@endphp

@if ($user_id)
    <input type="hidden" name="user_id" value="{{ $user_id }}">
@endif

<input value="{{ $schedule->title ?? 'Horario laboral' }}" autofocus value="Horario laboral" type="text"
    placeholder="Título (Opcional)" name="title">
<div class="flex items-center gap-2">
    <div class="p-1">Inicia:</div>
    <input value="{{ $startDate }}" required style="width: 170px" type="date" placeholder="Nombre"
        name="start_date">
</div>
<div>
    <div class="p-1">Días de la semana:</div>
    <div class="flex items-center gap-2">
        @foreach ($days as $day)
            <label title="{{ $day['name'] }}">
                @php
                    $checked = $daysJson && in_array($day['key'], $daysJson);
                @endphp
                <input data-nostyles {{ $checked ? 'checked' : '' }} class="sr-only peer hidden" type="checkbox"
                    name="days[]" value="{{ $day['key'] }}">
                <div
                    class="peer-checked:bg-blue-600 peer-checked:border-blue-600 cursor-pointer select-none peer-checked:text-white border grid place-content-center w-8 text-sm aspect-square rounded-full p-1">
                    {{ $day['short'] }}</div>
            </label>
        @endforeach
    </div>
</div>
<div class="flex border-y py-3 flex-col gap-2">
    <div class="flex items-center gap-2">
        <div class="p-1">Entrada:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $from }}" min="05:00" max="23:00" required type="time"
                value="05:00"name="from">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="p-1">Permite marcar entrada desde:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $from_start }}" min="04:00" max="24:00" required type="time" name="from_start">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="p-1">Permite marcar entrada hasta:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $from_start }}" min="04:00" max="24:00" required type="time" name="from_end">
        </div>
    </div>
</div>
<div class="flex border-y py-3 flex-col gap-2">

    <div class="flex items-center gap-2">
        <div class="p-1">Salida:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $to }}" min="05:00" max="23:00" required type="time" name="to">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="p-1">Permite marcar salida desde:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $to_start }}" min="04:00" max="24:00" required type="time" name="to_start">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="p-1">Permite marcar salida hasta:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $to_start }}" min="04:00" max="24:00" required type="time" name="to_end">
        </div>
    </div>
</div>
<div class="flex items-center gap-2">
    <div class="p-1">Finaliza:</div>
    <input value="{{ $endDate }}" style="width: 170px" type="date" name="end_date">
</div>
