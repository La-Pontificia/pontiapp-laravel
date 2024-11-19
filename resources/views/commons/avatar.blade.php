<div class="rounded-full overflow-hidden aspect-square {{ $className }}">
    @if ($src)
        <img src={{ $src }} class="w-full h-full object-cover" alt="{{ $alt }}">
    @else
        @php
            $name = explode(' ', $alt);
            $initials = strtoupper($name[0][0] . $name[1][0]);
        @endphp
        <div class="aspect-square w-full h-full text-stone-400 p-1.5 bg-stone-50 rounded-full border-2 border-stone-300">
            @svg('fluentui-person-20-o', 'w-full h-full')
        </div>
    @endif
</div>
