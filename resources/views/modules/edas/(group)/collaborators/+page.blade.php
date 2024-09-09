@extends('modules.edas.+layout')

@section('title', 'Gestión de Edas: Colaboradores')

@section('layout.edas')
    <div class="w-full pt-2 flex flex-col">
        <form class="flex dinamic-form-to-params p-1 items-center gap-2">
            <select class="w-fit bg-white" name="department">
                <option value="">Departamento</option>
                @foreach ($departments as $department)
                    <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                        value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>

            <select class="w-fit bg-white" name="job_position">
                <option value="">Puesto</option>
                @foreach ($job_positions as $job)
                    <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                        value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach
            </select>

            <label class="relative ml-auto w-[200px] max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('q') }}" placeholder="Filtrar usuarios..." type="search"
                    class="pl-9 w-full bg-white">
            </label>

            <button class="primary">
                Filtrar
            </button>
        </form>
        <div class="flex flex-col h-full">
            @if ($cuser->has('edas:show') || $cuser->isDev())
                @if ($users->isEmpty())
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @else
                    <div class="py-2 font-semibold text-lg px-2">
                        Colaboradores
                    </div>
                    <table>
                        <thead>
                            <tr class="border-b text-sm">
                                <td class="w-full"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="relative group border-b [&>td]:hover:bg-white [&>td]:p-3">
                                    <td class="rounded-l-2xl">
                                        <a class="absolute inset-0" href="/edas/{{ $user->id }}/eda">

                                        </a>
                                        <div class="flex items-center gap-2">
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-12',
                                                'key' => $user->id,
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-xl',
                                            ])
                                            <div class="flex-grow">
                                                <p class="text-nowrap">
                                                    {{ $user->last_name . ', ' . $user->first_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap font-semibold opacity-70 text-sm">
                                            {{ $user->edas->count() }} EDAs
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->supervisor)
                                            <div class="flex items-center gap-2">
                                                @includeIf('commons.avatar', [
                                                    'src' => $user->supervisor->profile,
                                                    'className' => 'w-12',
                                                    'key' => $user->supervisor->id,
                                                    'alt' =>
                                                        $user->supervisor->first_name .
                                                        ' ' .
                                                        $user->supervisor->last_name,
                                                    'altClass' => 'text-lg',
                                                ])
                                                <div>
                                                    <p class="text-xs opacity-60">
                                                        Bajo la supervisión de
                                                    </p>
                                                    <p class="text-nowrap">
                                                        {{ $user->supervisor->first_name }}
                                                        {{ $user->supervisor->last_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 py-4">
                        {!! $users->links() !!}
                    </footer>
                @endif
            @else
                <p class="p-20 grid place-content-center text-center">
                    No tienes permisos para visualizar estos datos.
                </p>
            @endif
        </div>
    </div>
@endsection
