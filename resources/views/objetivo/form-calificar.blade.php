@php
    $fechaFeedback = \Carbon\Carbon::parse($objetivo->feedback_fecha);
    $diferencia = $fechaFeedback->diffForHumans();
@endphp

<div class="grid grid-cols-4 gap-2 text-left">
    <div scope="row" class="flex items-center py-2 text-gray-900 whitespace-nowrap dark:text-white">
        <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
        <div class="pl-3 flex flex-col">
            <h3 class="text-lg font-semibold leading-4">
                {{ $objetivo->colaborador->nombres }}
                {{ $objetivo->colaborador->apellidos }}
            </h3>
            <div class="font-normal flex gap-2 items-center line-clamp-1 text-gray-500">
                <span class="text-xs text-neutral-600 capitalize">
                    {{ mb_strtolower($objetivo->colaborador->puesto->nombre_puesto, 'UTF-8') }}
                    -
                    {{ mb_strtolower($objetivo->colaborador->puesto->departamento->area->nombre_area, 'UTF-8') }}
                </span>

            </div>
        </div>
    </div>
    <div class="mb-1 col-span-4">
        <h4 class="text-2xl font-medium">{{ $objetivo->objetivo }}</h4>
    </div>
    <div class="col-span-4 grid grid-cols-1 gap-2">
        <div>
            <span class="font-semibold text-sm">Descripcion:</span>
            <p class="pl-3">
                {{ $objetivo->descripcion }}
            </p>
        </div>
        <div>
            <span class="font-semibold text-sm">Indicadores:</span>
            <p class="pl-3">
                {{ $objetivo->indicadores }}
            </p>
        </div>
    </div>
    <div class="col-span-4 pt-2 border-t grid grid-cols-2 gap-2">
        <div class="border-b col-span-2 pb-2 flex items-center gap-3">
            @if ($objetivo->estado === 0)
                <span
                    class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Desaprobado</span>
            @elseif ($objetivo->estado === 1)
                <span
                    class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
            @else
                <span
                    class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aprobado</span>
            @endif
            <span>{{ $objetivo->estado === 0 ? $diferencia : '' }}</span>
        </div>
        @if ($objetivo->estado === 0)
            <div class="col-span-2">
                <div class="flex p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div>
                        <span class="font-medium">Feedback enviado</span>
                        <ul class="mt-1.5 ml-4 list-disc list-inside">
                            <p>
                                {{ $objetivo->feedback }}
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if ($objetivo->estado != 0)
            <div class="">
                <label for="porcentaje"
                    class="block text-sm font-medium text-gray-900 dark:text-white">Porcentaje</label>
                <span class="text-sm pb-1 block text-neutral-600 capitalize">
                    % inicial (Colaborador) {{ $objetivo->porcentaje_inicial }}
                </span>
                <span class="relative block">
                    <span class="w-6 h-6 block absolute left-2 top-[50%] translate-y-[-50%] pointer-events-none">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.25 10.5a3.75 3.75 0 1 1 0-7.5 3.75 3.75 0 0 1 0 7.5zm-1.543 9.207a1 1 0 0 1-1.414-1.414l14-14a1 1 0 1 1 1.414 1.414l-14 14zM13 17.25a3.75 3.75 0 1 0 7.5 0 3.75 3.75 0 0 0-7.5 0zM7.25 8.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5zm11.25 8.75a1.75 1.75 0 1 1-3.5 0 1.75 1.75 0 0 1 3.5 0z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </span>
                    {{ Form::number('porcentaje', $objetivo->porcentaje, ['rows' => '10', 'id' => 'porcentaje', 'required' => 'required', 'class' => 'bg-gray-50 pl-10 border border-gray-300 text-gray-900 text-base text-lg font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('porcentaje') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => '% del objetivo']) }}
                    {!! $errors->first('porcentaje', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
                </span>
            </div>
            <div class="">
                <label for="nota_super" class="block text-sm font-medium text-gray-900 dark:text-white">Nota</label>
                <span class="text-sm pb-1 block text-neutral-600 capitalize">
                    Puntaje inicial (Colaborador) {{ $objetivo->nota_colab }}
                </span>
                {{ Form::select('nota_super', [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], $objetivo->nota_super, ['id' => 'autoevaluacion', 'required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-base text-lg font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('nota_colab') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => 'Selecionar nota']) }}
                {!! $errors->first('nota_super', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
            </div>
        @endif
    </div>
</div>
