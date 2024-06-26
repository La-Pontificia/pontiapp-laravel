@php
    $id_colab = $colaborador->id;
    $id_eda = request()->route('id_eda');
@endphp
<div class="p-1 sticky top-20 border-t z-10">
    <nav class="flex items-center font-medium text-neutral-500 text-base [&>a]:rounded-full">
        @foreach ($edas as $eda)
            <a href={{ "/meta/$id_colab/eda/$eda->id" }}
                class="hover:opacity-75 p-2 px-4 {{ $eda->id == $id_eda ? 'bg-slate-900 font-medium text-yellow-50' : '' }}">{{ $eda->año }}</a>
        @endforeach
    </nav>
</div>
