@extends('modules.+layout')

@section('title', 'Dashboard')

@section('content')
    <div class="h-full py-10 space-y-5">
        <div>
            <h1 class="text-2xl text-center tracking-tight font-serif text-stone-700">
                <span id="greeting"></span>,
                {{ Auth()->user()->first_name }}
            </h1>
        </div>
        <div class="max-w-5xl mx-auto overflow-x-auto">
            <h2 class="px-4 text-sm font-semibold flex items-center gap-2 opacity-70">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round">
                    <path d="M18 20a6 6 0 0 0-12 0" />
                    <circle cx="12" cy="10" r="4" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
                Usuarios registrados recientemente
            </h2>
            <div class="relative">
                <div class="bg-gradient-to-r from-[#e6f0f6] absolute top-0 left-0 h-full w-[50px] pointer-events-none">
                </div>
                <div class="bg-gradient-to-l from-[#e6f0f6] absolute top-0 right-0 h-full w-[50px] pointer-events-none">
                </div>
                <div class="flex items-center p-4 py-3 hidden-scroll overflow-x-auto gap-2">
                    @foreach ($users as $user)
                        <a href="/users/{{ $user->id }}"
                            class="border block w-[170px] min-w-[170px] rounded-2xl overflow-hidden bg-white shadow-md shadow-stone-400/5 hover:border-stone-400/60">
                            <div>
                                @include('commons.avatar', [
                                    'src' => $user->profile,
                                    'className' => 'w-full h-[90px] border-none rounded-none',
                                    'alt' => $user->first_name . ' ' . $user->last_name,
                                    'altClass' => 'text-3xl',
                                ])
                            </div>
                            <div class="p-3 text-left">
                                <p class="text-nowrap overflow-ellipsis overflow-hidden font-medium">{{ $user->first_name }}
                                    {{ $user->last_name }}
                                </p>
                                <p class="text-xs">{{ $user->role_position->name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const date = new Date();
        const hours = date.getHours();
        let greeting = '';

        if (hours >= 0 && hours < 12) {
            greeting = 'Buenos días';
        } else if (hours >= 12 && hours < 18) {
            greeting = 'Buenas tardes';
        } else {
            greeting = 'Buenas noches';
        }

        document.getElementById('greeting').textContent = greeting;
    </script>
@endsection
