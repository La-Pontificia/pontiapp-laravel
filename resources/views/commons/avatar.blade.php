<div class="rounded-full overflow-hidden border aspect-square {{ $className }}">
    @if ($src)
        <img src={{ $src }} class="w-full h-full object-cover" alt="">
    @else
        @php
            $name = explode(' ', $alt);
            $initials = strtoupper($name[0][0] . $name[1][0]);
        @endphp
        <div class="w-full h-full pointer-events-none select-none grid place-content-center bg-stone-50/70">
            <span class="font-semibold tracking-tight text-stone-600 {{ $altClass }}">{{ $initials }}</span>
        </div>
    @endif
</div>
