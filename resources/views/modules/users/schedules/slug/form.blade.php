@php
    $daysJson = json_decode($schedule->days) ?? ['2'];
    $startDate = $schedule->start_date ? date('Y-m-d', strtotime($schedule->start_date)) : null;
    $endDate = $schedule->end_date ? date('Y-m-d', strtotime($schedule->end_date)) : null;
    $from = $schedule->from ? date('H:i', strtotime($schedule->from)) : null;
    $to = $schedule->to ? date('H:i', strtotime($schedule->to)) : null;
@endphp
<input value="{{ $schedule->title ?? 'Horario laboral' }}" autofocus value="Horario laboral" type="text"
    placeholder="Título (Opcional)" name="title">
<div class="flex items-center gap-2">
    <div class="p-1">Inicia:</div>
    <input value="{{ $startDate }}" required style="width: 170px" type="date" placeholder="Nombre" name="start_date">
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
        <div class="p-1">Hora de inicio:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $from }}" min="05:00" max="23:00" required type="time"
                value="05:00"name="from">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="p-1">Hora fin:</div>
        <div class="grid grid-cols-2 gap-2">
            <input value="{{ $to }}" min="05:00" max="23:00" required type="time" name="to">
        </div>
    </div>
</div>
<div class="flex items-center gap-2">
    <div class="p-1">Finaliza:</div>
    <input value="{{ $endDate }}" style="width: 170px" type="date" name="end_date">
</div>
