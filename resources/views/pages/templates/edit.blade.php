@extends('layouts.app')

@section('title', 'Editar plantilla' . ' ' . $template->title)

@section('content')
    <div class="flex flex-col overflow-y-auto h-full">
        <nav class="border-b p-2 flex gap-3">
            <button onclick="window.history.back()"
                class="text-[#5b5fc7] hover:bg-indigo-100 font-semibold justify-center min-w-max flex items-center rounded-md p-2 gap-1 text-sm px-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-arrow-left">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span class="max-lg:hidden">Editar plantilla</span>
            </button>
        </nav>
        <div class="p-3 flex-grow w-full overflow-y-auto flex flex-col">
            <div class="max-w-2xl mx-auto w-full flex-grow flex flex-col overflow-y-auto">
                <div class="flex items-center gap-3">
                    <div class="w-8 rounded-xl overflow-hidden aspect-square">
                        <img src={{ $current_user->profile }} class="w-full h-full object-cover" alt="">
                    </div>
                    <div>
                        <p class="text-sm">
                            {{ $current_user->last_name }},
                            {{ $current_user->first_name }}
                        </p>
                        <p class="text-xs text-neutral-500">
                            Seguimiento y control con auditoria.
                        </p>
                    </div>
                </div>
                <form id="template-form" class="flex flex-col gap-4 overflow-y-auto w-full" role="form">
                    @include('components.template.form', [
                        'template' => $template,
                    ])
                </form>
            </div>
        </div>
        <div class="p-3 border-t border-neutral-300">
            <div class="max-w-2xl mx-auto flex gap-2">
                <button type="submit" form="template-form"
                    class="bg-[#056CCB] hover:bg-[#0564bc] disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-md p-2.5 gap-1 text-white text-sm font-semibold px-3">
                    Registrar
                </button>
                <button onclick="window.history.back()" type="button"
                    class="bg-[#E6E6E6] hover:bg-[#E6E6E6] text-black flex items-center rounded-md p-2.5 gap-1 text-sm font-semibold px-3">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
@endsection
