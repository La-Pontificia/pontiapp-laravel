@extends('cuestionario.layout')

@section('content-cuestionario')
    <header>
        <button type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2.5 text-center">
            Crear pregunta</button>
    </header>
    <div class="pt-3 max-w-3xl">
        <ul class="flex flex-col gap-3">
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Qué le aconsejas a tu colaborador que continúe mejorando?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Cuales son las fortalezas de tu colaborador?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Cuales son tus compromisos como líder para contribuir con el desempeño de tu colaborador?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Cuáles consideras que han sido tus principales logros (aquella tarea extra, actividad donde hayas logrado
                optimizar o reducir costos y tiempo, entre otras)?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿En qué consideras que debes seguir trabajando?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Que le aconsejas a tu lider que deje de hacer?
            </li>
            <li class="bg-white p-4 rounded-2xl border max-w-max">
                ¿Qué le aconsejas a tu líder que empiece hacer que hoy no está haciendo?
            </li>
        </ul>
    </div>
@endsection
