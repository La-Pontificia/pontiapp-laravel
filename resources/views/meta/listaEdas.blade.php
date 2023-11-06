<header class="border-b border-neutral-200">
    <nav class="flex items-center">
        @foreach ($edas as $eda)
            <a href={{ "/meta/$id_colab/eda/$eda->id" }}
                class="font-normal border border-transparent text-blue-600 hover:text-red-500 rounded-t-xl px-4 py-2 {{ $eda->id == $id_eda ? 'border-t-neutral-300 border-l-neutral-300 border-r-neutral-300 text-neutral-700 -mb-1 bg-white' : '' }}">{{ $eda->eda->año }}</a>
        @endforeach
    </nav>
</header>
