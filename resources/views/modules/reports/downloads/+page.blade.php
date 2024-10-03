@extends('modules.reports.+layout')

@section('title', 'Gestión Reportes - Descargas')

@section('layout.reports')
    <div class="w-full max-w-7xl mx-auto">
        <h2 class="pt-5">
            Reportes listos para descargar.</h2>
        <form class="flex dinamic-form-to-params pb-4 items-center gap-4">
            <label class="relative mt-6 ml-auto w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..." type="search"
                    class="pl-9 w-full bg-white">
            </label>
            <button class="primary mt-6">
                Filtrar
            </button>
        </form>
        <div class="flex flex-col overflow-x-auto w-full">
            @if ($reports->count() > 0)
                <table>
                    <thead>
                        <tr class="border-b font-semibold [&>td]:p-2 text-sm">
                            <td></td>
                            <td></td>
                            <td>Estado</td>
                            <td>Info</td>
                            <td>Generado por</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class='relative group border-b [&>td]:p-3'>
                                <td>
                                    <svg width="20" height="20" viewBox="0 0 32 32"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <defs>
                                                <linearGradient id="a" x1="4.494" y1="-2092.086" x2="13.832"
                                                    y2="-2075.914" gradientTransform="translate(0 2100)"
                                                    gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#18884f"></stop>
                                                    <stop offset="0.5" stop-color="#117e43"></stop>
                                                    <stop offset="1" stop-color="#0b6631"></stop>
                                                </linearGradient>
                                            </defs>
                                            <title>file_type_excel</title>
                                            <path
                                                d="M19.581,15.35,8.512,13.4V27.809A1.192,1.192,0,0,0,9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5Z"
                                                style="fill:#185c37"></path>
                                            <path
                                                d="M19.581,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5L19.581,16l5.861,1.95L30,16V9.5Z"
                                                style="fill:#21a366"></path>
                                            <path d="M8.512,9.5H19.581V16H8.512Z" style="fill:#107c41"></path>
                                            <path
                                                d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z"
                                                style="opacity:0.10000000149011612;isolation:isolate"></path>
                                            <path
                                                d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                                            <path
                                                d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                                            <path
                                                d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z"
                                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                                            <path
                                                d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z"
                                                style="fill:url(#a)"></path>
                                            <path
                                                d="M5.7,19.873l2.511-3.884-2.3-3.862H7.758L9.013,14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359,3.84,2.419,3.905H10.821l-1.45-2.711A2.355,2.355,0,0,1,9.2,16.8H9.176a1.688,1.688,0,0,1-.168.351L7.515,19.873Z"
                                                style="fill:#fff"></path>
                                            <path d="M28.806,3H19.581V9.5H30V4.191A1.192,1.192,0,0,0,28.806,3Z"
                                                style="fill:#33c481">
                                            </path>
                                            <path d="M19.581,16H30v6.5H19.581Z" style="fill:#107c41"></path>
                                        </g>
                                    </svg>
                                </td>
                                <td>
                                    <div>
                                        <p class="text-nowrap font-medium">
                                            {{ $report->file_name ?? 'Error' }}
                                        </p>
                                        <p class="text-sm">
                                            {{ $report->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-semibold">
                                        @if ($report->status == 'error')
                                            <span class="text-red-500">Error</span>
                                        @else
                                            <span class="text-green-500">Listo</span>
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="line-clamp-2">
                                        {{ $report->title ?? $report->error_message }}
                                    </p>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @include('commons.avatar', [
                                            'src' => $report->generatedBy->profile,
                                            'className' => 'w-10',
                                            'key' => $report->generatedBy->id,
                                            'alt' => $report->generatedBy->names(),
                                            'altClass' => 'text-lg',
                                        ])
                                        <div class="flex-grow">
                                            <p class="text-nowrap">
                                                {{ $report->generatedBy->names() }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($report->status != 'error')
                                        <a target="_blank" rel="noopener noreferrer" href={{ $report->download_link }}
                                            class="text-rose-500 hover:underline text-sm">
                                            @svg('fluentui-document-table-20-o', 'w-5 h-5')
                                        </a>
                                    @endif
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

@endsection
