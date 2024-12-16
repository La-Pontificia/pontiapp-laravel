@php
    $tabs = [
        [
            'title' => 'Modulos',
            'href' => '/tickets/settings/modules',
            'active' => request()->is('tickets/settings/modules*'),
            'icon' => 'fluentui-board-split-20-o',
            'active-icon' => 'fluentui-board-split-20',
        ],
        [
            'title' => 'Asuntos',
            'href' => '/tickets/settings/subjects',
            'active' => request()->is('tickets/settings/subjects*'),
            'icon' => 'fluentui-notepad-20-o',
            'active-icon' => 'fluentui-notepad-20',
        ],
        [
            'title' => 'Unidades de negocios',
            'href' => '/tickets/settings/business-units',
            'active' => request()->is('tickets/settings/business-units*'),
            'icon' => 'fluentui-building-20-o',
            'active-icon' => 'fluentui-building-20',
        ],
    ];
@endphp
<header>
    <h1 class="font-semibold text-lg px-2 py-1">
        Ajustes Tickets
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
