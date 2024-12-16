@php
    $tabs = [
        [
            'title' => 'Rapida',
            'href' => '/tickets/create',
            'active' => request()->is('tickets/create'),
            'icon' => 'fluentui-flash-20-o',
            'active-icon' => 'fluentui-flash-20',
        ],
        [
            'title' => 'Manual',
            'href' => '/tickets/create/manual',
            'active' => request()->is('tickets/create/manual'),
            'icon' => 'fluentui-hand-draw-20-o',
            'active-icon' => 'fluentui-hand-draw-20',
        ],
    ];
@endphp

<header>
    <h1 class="font-semibold text-lg px-2 py-1">
        Registro de Tickets
    </h1>
    <nav class="flex items-center w-fit p-1.5 gap-2 bg-white rounded-xl">
        @foreach ($tabs as $tab)
            <a href="{{ $tab['href'] }}"
                class="px-3 py-1 text-sm flex items-center gap-1 rounded-full font-medium {{ $tab['active'] ? 'text-black bg-yellow-300 hover:bg-yellow-300' : 'text-stone-800 border-transparent hover:bg-stone-200' }}">
                @svg($tab['active'] ? $tab['active-icon'] : $tab['icon'], 'w-5 h-5')
                {{ $tab['title'] }}
            </a>
        @endforeach
    </nav>
</header>
