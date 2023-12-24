@extends('reportes.layout')

@section('content-reportes')
    <div class="w-full">
        <div class="flex p-4 overflow-x-auto gap-4 shadow-md rounded-xl">
            <div class="w-full flex flex-col gap-3">
                @include('reportes.search-colaborador')
                @include('reportes.objetivos.nav')

                <div class="relative  sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Objetivo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Eva 01
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Eva 02
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Eda
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Estado
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('reportes.objetivos.list', ['objetivos' => $objetivos])
                        </tbody>
                    </table>
                    <footer class="mt-4">
                        {!! $objetivos->links() !!}
                    </footer>
                </div>
            </div>
            @include('reportes.objetivos.chart')
        </div>

    </div>
@endsection
