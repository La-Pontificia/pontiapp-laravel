@extends('layouts.sidebar')

@section('content-sidebar')
    <nav class="border-b sticky top-16 bg-neutral-50 border-gray-200">
        <ul class="flex flex-wrap -mb-px text-base font-medium text-center text-gray-500">
            <li class="me-2">
                <a href="{{ route('cuestionarios.index') }}"
                    class="{{ request()->is('cuestionarios') ? 'text-blue-600 border-blue-600' : 'hover:text-gray-600 border-transparent hover:border-gray-300' }} inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg active group"
                    aria-current="page">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>Plantillas
                </a>
            </li>
            <li class="me-2">
                <a href="{{ route('cuestionarios.preguntas') }}"
                    class="{{ request()->is('cuestionarios/preguntas') ? 'text-blue-600 border-blue-600' : 'hover:text-gray-600 border-transparent hover:border-gray-300' }} inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 18 20">
                        <path
                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                    </svg>Preguntas
                </a>
            </li>
        </ul>
    </nav>
    <section class="p-2">
        @yield('content-cuestionario')
    </section>
@endsection
