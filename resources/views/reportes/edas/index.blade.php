@extends('reportes.layout')

@section('content-reportes')
    @php
        $mostrareva1 = request()->query('eva1');
        $mostrareva2 = request()->query('eva2');
    @endphp

    <div class="w-full">
        <div class="flex p-4 gap-4 shadow-md rounded-xl">
            <div class="w-full flex flex-col gap-3">
                @include('reportes.search-colaborador')
                @include('reportes.edas.nav')
                @include('reportes.edas.charts')

                <div class="relative  overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="[&>th]:text-left">
                                <th scope="col" class="px-6 w-[50px] max-w-[50px] min-w-[50px] py-3">
                                    Eda
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Colaborador
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cargo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Puesto
                                </th>
                                <th scope="col" class="px-6  py-3">
                                    <span class="text-center block">
                                        Enviado
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="text-center block">
                                        Aprobado
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="text-center block">
                                        Cerrado
                                    </span>
                                </th>
                                @include('reportes.edas.header-eva', ['title' => 'Eva 01'])
                                @if ($mostrareva2)
                                    @include('reportes.edas.header-eva', ['title' => 'Eva 02'])
                                @endif

                                <th scope="col" class="px-6 py-3">
                                    <span class="text-center block">
                                        Cuestionario
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('reportes.edas.list', ['edas' => $edas])
                        </tbody>
                    </table>
                    {{-- <footer class="mt-4">
                        {!! $objetivos->links() !!}
                    </footer> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
