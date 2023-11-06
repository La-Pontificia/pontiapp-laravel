@extends('layouts.meta')

@section('content-meta')
    <header class="p-4">
        <ul class="flex gap-2 items-center">
            @foreach ($edas as $eda)
                <li>
                    <a href={{ "/meta/$id_colab/eda/$eda->id" }}
                        class="bg-neutral-100 p-2 rounded-lg font-medium px-5">{{ $eda->eda->año }}</a>
                </li>
            @endforeach
        </ul>
    </header>
@endsection
