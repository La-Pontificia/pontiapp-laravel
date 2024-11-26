@extends('modules.reports.+layout')

@section('title', 'Gestión Reportes - Descargas')

@section('layout.reports')
    <div class="w-full flex flex-col flex-grow">
        <nav class="px-2">
            <h1 class="font-semibold text-lg">
                Archivos Generados
            </h1>
        </nav>
        <form class="flex dinamic-form-to-params ml-auto pb-4 items-center gap-4">
            <label class="relative w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input style="padding-left: 35px" value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..."
                    type="search" class="pl-9 w-full bg-white rounded-full">
            </label>
            <button class="primary">
                Filtrar
            </button>
        </form>
        <div class="p-2 overflow-y-auto flex flex-grow flex-col">
            <div class="bg-white overflow-y-auto border border-neutral-200 shadow-md flex-grow rounded-2xl">
                <div class="flex flex-col overflow-x-auto w-full">
                    @if ($reports->count() > 0)
                        <table>
                            <thead>
                                <tr class="border-b font-semibold [&>td]:text-nowrap [&>td]:p-3 text-sm">
                                    <td>
                                        <p class="pl-10">Nombre</p>
                                    </td>
                                    <td>Fecha</td>
                                    <td>Generado Por</td>
                                    <td>Tamaño de archivo</td>
                                    <td class="w-full"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    @php
                                        // calculate file size
                                        $fileSize = $report->file_url ? filesize(public_path($report->file_url)) : 0;
                                    @endphp
                                    <tr class='relative group border-b [&>td]:p-3'>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <svg width="32" height="32" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.5 29h19c.275 0 .5-.225.5-.5V9h-4.5c-.827 0-1.5-.673-1.5-1.5V3H9.5c-.275 0-.5.225-.5.5v25c0 .275.225.5.5.5z"
                                                        fill="#fff" />
                                                    <path d="M28.293 8 24 3.707V7.5c0 .275.225.5.5.5h3.793z"
                                                        fill="#fff" />
                                                    <path opacity=".67" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="m29.56 7.854-5.414-5.415A1.51 1.51 0 0 0 23.086 2H9.5C8.673 2 8 2.673 8 3.5v25c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5V8.914c0-.4-.156-.777-.44-1.06zM24 3.707 28.293 8H24.5a.501.501 0 0 1-.5-.5V3.707zM9.5 29h19c.275 0 .5-.225.5-.5V9h-4.5c-.827 0-1.5-.673-1.5-1.5V3H9.5c-.275 0-.5.225-.5.5v25c0 .276.224.5.5.5z"
                                                        fill="#605E5C" />
                                                    <path d="M25 23h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#134A2C" />
                                                    <path d="M20 23h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#185C37" />
                                                    <path d="M25 19h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#21A366" />
                                                    <path d="M20 19h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#107C41" />
                                                    <path d="M25 15h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#33C481" />
                                                    <path d="M20 15h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z" fill="#21A366" />
                                                    <path
                                                        d="M3.5 25h11a1.5 1.5 0 0 0 1.5-1.5v-11a1.5 1.5 0 0 0-1.5-1.5h-11A1.5 1.5 0 0 0 2 12.5v11A1.5 1.5 0 0 0 3.5 25z"
                                                        fill="#107C41" />
                                                    <path
                                                        d="m6 22 2.174-4.01L6.182 14h1.602l1.087 2.549c.1.242.169.423.206.542h.015c.071-.194.146-.382.224-.564L10.478 14h1.47l-2.042 3.967L12 22h-1.565L9.18 19.2c-.06-.12-.11-.246-.15-.375h-.018a1.93 1.93 0 0 1-.145.363L7.574 22H6z"
                                                        fill="#F9F7F7" />
                                                </svg>
                                                <p class="text-nowrap font-medium">
                                                    {{ $report->title }}.{{ $report->ext }}
                                                </p>
                                                <button title="Editar nombre del archivo"
                                                    data-modal-target="dialog-{{ $report->id }}"
                                                    data-modal-toggle="dialog-{{ $report->id }}"
                                                    class="opacity-0 text-blue-600 group-hover:opacity-100">
                                                    @svg('fluentui-cloud-edit-16-o', 'w-5 h-5')
                                                </button>


                                                <div id="dialog-{{ $report->id }}" tabindex="-1" aria-hidden="true"
                                                    class="dialog hidden">
                                                    <div class="content lg:max-w-lg max-w-full">
                                                        <header>
                                                            Editar archivo: {{ $report->name }}
                                                        </header>
                                                        <form action="/api/reports/{{ $report->id }}" method="POST"
                                                            id="dialog-{{ $report->id }}-form"
                                                            class="dinamic-form body grid gap-4 overflow-y-auto">
                                                            <label class="label py-2">
                                                                <span>Nombre del archivo</span>
                                                                <div class="flex items-end">
                                                                    <input type="text" class="w-full"
                                                                        name="title"value="{{ $report->title }}" required>
                                                                    <span class="opacity-70">
                                                                        .{{ $report->ext }}
                                                                    </span>
                                                                </div>
                                                            </label>
                                                        </form>
                                                        <footer>
                                                            <button data-modal-hide="dialog-{{ $report->id }}"
                                                                type="button">Cancelar</button>
                                                            <button form="dialog-{{ $report->id }}-form" type="submit">
                                                                Guardar</button>
                                                        </footer>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-nowrap ">
                                                {{ $report->created_at->diffForHumans() }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                {{ $report->generatedBy->names() }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                {{ $fileSize > 0 ? round($fileSize / 1024, 2) : 0 }} KB
                                            </p>
                                        </td>
                                        <td>
                                            <div class="justify-end flex">
                                                <button data-url="{{ $report->download_link }}"
                                                    data-name="{{ $report->title }}.{{ $report->ext }}"
                                                    class="secondary flex dinamic-download-file items-center gap-1">
                                                    @svg('fluentui-arrow-upload-16', 'w-5 h-5 rotate-180')
                                                    Descargar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- <div class="flex relative items-center p-2.5 gap-2">
                                            <div class="flex-grow">
                                                <p>
                                                    {{ $report->title }} <span class="text-sm text-blue-600">
                                                        Hace {{ $report->created_at->diffForHumans() }}
                                                    </span>
                                                </p>
                                                <p class="text-sm">
                                                    Generado por {{ $report->generatedBy->names() }} el
                                                    {{ $report->created_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <a target="_blank" rel="noopener noreferrer" href={{ $report->download_link }}
                                                    class="text-blue-500 hover:underline text-sm">
                                                    Descargar
                                                </a>
                                            </div>
                                        </div> --}}
                                @endforeach
                            </tbody>
                        @else
                            <p class="p-20 grid place-content-center text-center">
                                No hay nada que mostrar.
                            </p>
                    @endif
                    @if ($reports->count() > 19)
                        <footer class="px-5 py-4">
                            {!! $reports->links() !!}
                        </footer>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
