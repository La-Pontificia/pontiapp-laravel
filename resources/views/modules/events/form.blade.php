@php
    $name = isset($event) ? $event->name : null;
    $description = isset($event) ? $event->description : null;
    $start_date = isset($event) ? $event->start_date->format('Y-m-d') : null;
    $end_date = isset($event) ? $event->end_date->format('Y-m-d') : null;

@endphp
<label class="label">
    <span>Nombre</span>
    <input autofocus required type="text" name="name" placeholder="" value="{{ $name }}">
</label>

<label class="label">
    <span>Descripcion</span>
    <textarea rows="5" required type="text" name="description" placeholder="Descripcion del evento">{{ $description }}</textarea>
</label>

<div class="grid grid-cols-2 gap-4">
    <label class="label">
        <span>Fecha de inicio</span>
        <input required type="date" name="start_date" value="{{ $start_date }}">
    </label>
    <label class="label">
        <span>Fecha de fin</span>
        <input required type="date" name="end_date" value="{{ $end_date }}">
    </label>
</div>
