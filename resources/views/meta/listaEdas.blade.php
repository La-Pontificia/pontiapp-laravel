<div class="py-3 sticky top-14 bg-neutral-50 z-10">
    <header class="border-b p-2 border-neutral-200">
        <nav class="flex items-center font-medium text-neutral-500 text-lg [&>a]:rounded-full">
            @foreach ($edas as $eda)
                <a href={{ "/meta/$id_colab/eda/$eda->id" }}
                    class="hover:opacity-75 p-2 px-4 {{ $eda->id == $id_eda ? 'bg-slate-900 font-medium text-yellow-50' : '' }}">{{ $eda->año }}</a>
            @endforeach
        </nav>
    </header>
</div>
