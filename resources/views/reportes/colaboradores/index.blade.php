@extends('reportes.layout')

@section('content-reportes')
    @php
        $cargoRecover = request()->query('cargo');
        $puestoRecover = request()->query('puesto');
        $departamentoRecover = request()->query('departamento');
        $areaRecover = request()->query('area');
        $estadoRecover = request()->query('estado');
        $query = request()->query('query');

    @endphp

    <div class="w-full">
        <div class="flex gap-4">
            <div class="w-full flex flex-col gap-3">
                @include('reportes.colaboradores.header')
                @include('reportes.colaboradores.chart')
                <div class="relative rounded-xl shadow-md overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50">
                            <tr class="[&>th]:text-left [&>th]:px-3 [&>th]:py-3">
                                <th class="w-[50px]  max-w-[50px]">
                                    <div class="text-center">
                                        N°
                                    </div>
                                </th>
                                <th>
                                    APELLIDOS Y NOMBRES
                                </th>
                                <th>
                                    SUPERVISOR
                                </th>
                                <th>
                                    Correo
                                </th>
                                <th>
                                    Area
                                </th>
                                <th>
                                    Departamento
                                </th>
                                <th>
                                    Cargo
                                </th>
                                <th>
                                    Puesto
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    Sede
                                </th>
                                <th>
                                    Rol
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colaboradores as $index => $colaborador)
                                @php
                                    $rol = null;
                                    if ($colaborador->rol === 0) {
                                        $rol = 'Colaborador';
                                    }
                                    if ($colaborador->rol === 1) {
                                        $rol = 'Admin';
                                    }
                                    if ($colaborador->rol === 2) {
                                        $rol = 'Dev';
                                    }

                                @endphp

                                <tr class="bg-white border-b [&>td]:px-3 text-neutral-950">
                                    <th scope="row" class=" text-center py-4 font-semibold text-gray-900">
                                        <span>
                                            {{ $index + 1 }}
                                        </span>
                                    </th>
                                    <td>
                                        <div class="font-semibold flex gap-2">
                                            <div
                                                class="w-[40px] h-[40px] min-w-[40px] bg-neutral-100 border rounded-xl overflow-hidden">
                                                @if ($colaborador->perfil)
                                                    <img class="w-full h-full object-cover" src="{{ $colaborador->perfil }}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="min-w-max flex-nowrap">
                                                    {{ $colaborador->apellidos }}
                                                    {{ $colaborador->nombres }}
                                                </h4>
                                                <div class="font-normal text-neutral-500">
                                                    {{ $colaborador->dni }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($colaborador->id_supervisor)
                                            @php
                                                $supervisor = $colaborador->supervisor;
                                            @endphp
                                            <div class="font-semibold flex gap-2">
                                                <div
                                                    class="w-[40px] min-w-[40px] h-[40px] bg-neutral-100 border rounded-xl overflow-hidden">
                                                    @if ($supervisor->perfil)
                                                        <img class="w-full h-full object-cover"
                                                            src="{{ $supervisor->perfil }}" alt="">
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="min-w-max flex-nowrap">
                                                        {{ $supervisor->apellidos }}
                                                        {{ $supervisor->nombres }}
                                                    </h4>
                                                    <div class="font-normal text-neutral-500">
                                                        {{ $supervisor->dni }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->correo_institucional }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->puesto->departamento->area->nombre_area }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->puesto->departamento->nombre_departamento }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->puesto->cargo->nombre_cargo }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->puesto->nombre_puesto }}
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="font-semibold text-center {{ $colaborador->estado ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $colaborador->estado ? 'Activo' : 'Inactivo' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-normal">
                                            {{ $colaborador->sede->nombre }}
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="p-1 max-w-max mx-auto rounded-full bg-slate-900 text-white px-3 font-semibold text-center">
                                            {{ $rol }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="p-10 grid place-content-center">
                                            @include('commons.not-value')
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
