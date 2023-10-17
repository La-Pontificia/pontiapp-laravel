@extends('layouts.profile')

@section('content-profile')
    <section>
        @if ($youSupervise || $isMyprofile)
            <nav class="p-2 px-4">
                <ul class="flex items-center gap-1 h-[50px] pb-3">
                    @foreach ($edas as $eda)
                        <li class="">
                            <a href="{{ $isMyprofile ? "/me/eda/$eda->id" : "/profile/$colaborador->id/eda/$eda->id" }}"
                                class="p-2 rounded-full font-semibold px-4 {{ $edaColab->id == $eda->id ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-neutral-200 hover:bg-neutral-100' }} ">
                                {{ $eda->eda->year }}-{{ $eda->eda->n_evaluacion }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
        @yield('content-eda')
    </section>
@endsection
