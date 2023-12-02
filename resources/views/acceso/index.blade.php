@extends('layouts.sidebar')

@section('content-sidebar')
    @php
        $isAdmin = $colaborador->rol == 1;
        $isAccesCurrentColab = $colaborador_actual->rol == 1 || $colaborador_actual->rol == 2;
        $isDev = $colaborador->rol == 2;
    @endphp
    <div class="p-3">
        <div class="max-w-2xl relative mx-auto w-full p-5 bg-white rounded-3xl border">
            <div class="flex gap-3 items-center">
                <div>
                    <h3 class="text-2xl font-bold">Accesos / Previlegios</h3>
                    <p class="text-base opacity-70">{{ $colaborador->nombres }} {{ $colaborador->apellidos }}<span
                            class="p-2 py-1 rounded-lg font-normal bg-violet-600 text-sm text-white">
                            {{ $colaborador->rol == 1 ? 'Admin' : 'Developer' }}
                        </span></p>
                </div>
                <div class="ml-auto flex flex-col gap-1">
                    @if ($isDev)
                        <label class="relative opacity-50 inline-flex items-center cursor-pointer">
                            <input disabled data-id="{{ $colaborador->id }}" type="checkbox"
                                class="sr-only toggle-access peer" {{ $isDev ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                            </div>
                            <span class="ms-3 text-base font-medium text-gray-900">Developer</span>
                        </label>
                    @else
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input disabled data-id="{{ $colaborador->id }}" type="checkbox"
                                class="sr-only toggle-access peer" {{ $isAdmin ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-base font-medium text-gray-900">Administrador</span>
                        </label>
                    @endif
                </div>
            </div>
            @if (!$isDev)
                <div class="relative">
                    <div class="flex flex-col divide-y gap-10 border-t pt-3 mt-3">
                        <div>
                            <h3 class="font-medium pb-1">Objetivos</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_objetivo->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_objetivo->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_objetivo->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_objetivo->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_objetivo->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_objetivo->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_objetivo->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_objetivo->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Colaboradores</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_colaborador->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_colaborador->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_colaborador->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_colaborador->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_colaborador->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_colaborador->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_colaborador->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_colaborador->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Edas</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_eda->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer" {{ $acceso_eda->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_eda->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_eda->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_eda->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer" {{ $acceso_eda->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_eda->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer" {{ $acceso_eda->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Departamentos</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_departamento->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_departamento->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_departamento->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_departamento->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_departamento->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_departamento->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_departamento->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_departamento->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Cargos</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_cargo->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_cargo->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_cargo->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_cargo->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_cargo->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_cargo->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_cargo->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer" {{ $acceso_cargo->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Areas</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_area->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_area->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_area->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_area->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_area->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_area->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_area->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer" {{ $acceso_area->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Puestos</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_puesto->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_puesto->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_puesto->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_puesto->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_puesto->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_puesto->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_puesto->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_puesto->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium pb-1">Accesos</h3>
                            <div class="flex gap-2 justify-between px-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_acceso->id }}" type="checkbox" name="crear"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_acceso->crear == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Crear</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_acceso->id }}" type="checkbox" name="leer"
                                        class="sr-only toggle-access peer" {{ $acceso_acceso->leer ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Ver</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_acceso->id }}" type="checkbox" name="actualizar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_acceso->actualizar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Actualizar</span>
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input data-id="{{ $acceso_acceso->id }}" type="checkbox" name="eliminar"
                                        class="sr-only toggle-access peer"
                                        {{ $acceso_acceso->eliminar ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-base font-medium text-gray-900">Eliminar</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-200 mt-3">No es posible cambiar los accesos de
                    este
                    usuario</div>
            @endif
        </div>
    </div>
@endsection
