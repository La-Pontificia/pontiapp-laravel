@extends('layouts.sidebar')

@section('content-sidebar')
    @php
        $hasAccess = in_array('auditoria', $colaborador_actual->privilegios);
    @endphp
    @if (!$hasAccess)
        <script>
            window.location = "/";
        </script>
    @else
        <div class=" mx-auto w-full">
            @include('auditoria.search-colaborador')
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-900">
                    <thead class="text-sm text-gray-800 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Usuario / Colaborador
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Modulo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Titulo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descripcion
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($auditoria as $item)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <span class="w-10 h-10 block overflow-hidden rounded-full">
                                            <img class="w-full h-full object-cover"
                                                src={{ $item->colaborador->perfil ? $item->colaborador->perfil : '/profile-user.png' }}
                                                alt="">
                                        </span>
                                        <div class="flex flex-col">
                                            {{ $item->colaborador->nombres }} {{ $item->colaborador->apellidos }}
                                            <span class="opacity-60 text-xs">{{ $item->colaborador->dni }} </span>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-1">
                                    {{ $item->modulo }}
                                </td>
                                <td class="px-6 py-1 font-semibold">
                                    <div class="whitespace-nowrap">
                                        {{ $item->titulo }}
                                    </div>
                                </td>
                                <td class="px-6 py-1">
                                    <div class="whitespace-nowrap">
                                        {{ $item->descripcion }}
                                    </div>
                                </td>
                                <td class="px-6 py-1">
                                    <span class="text-sm whitespace-nowrap text-neutral-400 hover:underline">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="p-10 grid place-content-center">
                                        No hay historial de actividades disponibles
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <footer class="mt-4">
                {!! $auditoria->links() !!}
            </footer>
        </div>
    @endif
@endsection
