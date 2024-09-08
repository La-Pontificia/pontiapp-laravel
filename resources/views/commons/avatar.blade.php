@php
    $bgs = [
        'bg-stone-200',
        'bg-red-200',
        'bg-blue-200',
        'bg-green-200',
        'bg-orange-200',
        'bg-yellow-200',
        'bg-cyan-200',
        'bg-sky-200',
        'bg-lime-200',
        'bg-violet-200',
        'bg-purple-200',
        'bg-rose-200',
        'bg-teal-200',
        'bg-indigo-200',
        'bg-pink-200',
        'bg-amber-200',
        'bg-emerald-200',
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
