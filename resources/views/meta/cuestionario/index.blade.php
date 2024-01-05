@php
    $hasSend = in_array('enviar_cuestionario', $colaborador_actual->privilegios);
@endphp
<div class="w-full border-b my-1"></div>
<div
    class="flex flex-col border rounded-2xl p-2 gap-2 {{ !$cerrado ? 'opacity-50 pointer-events-none select-none' : '' }}">
    <h1 class="p-1 font-semibold text-lg">Cuestionarios</h1>

    @if ($hasSend)
        @include('meta.cuestionario.colab')
        @include('meta.cuestionario.super')
    @endif
</div>
