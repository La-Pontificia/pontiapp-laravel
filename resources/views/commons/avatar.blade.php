@php
    $bgs = [
        'bg-stone-100',
        'bg-red-100',
        'bg-blue-100',
        'bg-green-100',
        'bg-orange-100',
        'bg-yellow-100',
        'bg-cyan-100',
        'bg-sky-100',
        'bg-lime-100',
        'bg-violet-100',
        'bg-purple-100',
        'bg-rose-100',
        'bg-teal-100',
        'bg-indigo-100',
        'bg-pink-100',
        'bg-amber-100',
        'bg-emerald-100',
    ];

    $key = isset($key) ? $key : 'random';
    $randomBg = null;

    if ($key === 'random') {
        $randomBg = $bgs[array_rand($bgs)];
    } else {
        $hash = crc32($key);
        $randomBg = $bgs[$hash % count($bgs)];
    }

@endphp
<div class="rounded-full overflow-hidden aspect-square {{ $className }}">
    @if ($src)
        <img src={{ $src }} class="w-full h-full object-cover" alt="{{ $alt }}">
    @else
        @php
            $name = explode(' ', $alt);
            $initials = strtoupper($name[0][0] . $name[1][0]);
        @endphp
        <div class="w-full {{ $randomBg }} h-full pointer-events-none select-none grid place-content-center">
            <span class="font-semibold tracking-tight text-stone-600 {{ $altClass }}">{{ $initials }}</span>
        </div>
    @endif
</div>
