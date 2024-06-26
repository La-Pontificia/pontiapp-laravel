@php
    $id_eda = request()->route('id_eda');
@endphp

<header class="p-2 sticky flex items-center gap-3 top-16 z-10 bg-gray-50">
    <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}"
        class="flex items-center gap-2 hover:bg-neutral-200 text-neutral-500 max-w-max px-3 rounded-xl">
        <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_iconCarrier">
                <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </g>
        </svg>
        <h2 class="text-xl p-2 font-semibold">{{ $title }}</h2>
    </a>
</header>
