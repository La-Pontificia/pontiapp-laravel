<div class="py-3 sticky top-14 bg-neutral-50 z-10">
    <header class="border-b border-neutral-200">
        <nav class="flex items-center">
            @foreach ($edas as $eda)
                <a href={{ "/meta/$id_colab/eda/$eda->id" }}
                    class="text-base font-semibold border border-transparent text-blue-600 hover:text-red-500 rounded-t-xl px-4 py-2 {{ $eda->id == $id_eda ? 'border-t-neutral-300 border-l-neutral-300 border-r-neutral-300 text-neutral-700 -mb-1 bg-neutral-50' : '' }}">{{ $eda->eda->año }}</a>
            @endforeach
        </nav>
    </header>
</div>
