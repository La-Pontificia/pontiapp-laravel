@extends('modules.edas.(group).+layout')

@section('title', 'Gestión de Edas: Colaboradores')

@section('layout.group.edas')
    <div class="w-full flex flex-col overflow-y-auto">
        <div class="flex items-center gap-2 p-3 pt-0">
            <label class="relative w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('bx-search', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('q') }}" placeholder="Filtrar usuarios..." type="search"
                    class="w-full pl-9 dinamic-search">
            </label>

            <select class="dinamic-select w-[100px]" name="status">
                <option value="0">Estado</option>
                <option {{ request()->query('status') === 'actives' ? 'selected' : '' }} value="actives">Activos
                </option>
                <option {{ request()->query('status') === 'inactives' ? 'selected' : '' }} value="inactives">Inactivos
                </option>
            </select>

            <select class="dinamic-select w-[70px]" name="role">
                <option value="0">Rol</option>
                @foreach ($user_roles as $role)
                    <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                        {{ $role->title }}</option>
                @endforeach
            </select>

            <select class="dinamic-select w-[140px]" name="department">
                <option value="0">Departamento</option>
                @foreach ($departments as $department)
                    <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                        value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <select class="dinamic-select w-[100px]" name="job_position">
                <option value="0">Puesto</option>
                @foreach ($job_positions as $job)
                    <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                        value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col h-full divide-y overflow-y-auto">
            @if ($cuser->has('edas:show') || $cuser->isDev())
                @if ($users->isEmpty())
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @else
                    <table>
                        <thead>
                            <tr class="border-b text-sm">
                                <td class="text-left pb-1.5 w-full px-2">Usuario/Colaborador</td>
                                <td></td>
                                <td class="text-center pb-1.5 px-4">Edas</td>
                                <td class="text-left pb-1.5">Bajo supervisión de </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($users as $user)
                                <tr class="relative group hover:bg-neutral-100 [&>td]:p-3">
                                    <td>
                                        <a title="Ver edas del usuario" href="/edas/{{ $user->id }}/eda"
                                            class="absolute inset-0">
                                        </a>
                                        <div class="flex items-center gap-2">
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-8',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-base',
                                            ])
                                            <div class="flex-grow">
                                                <p class="group-hover:underline text-nowrap">
                                                    {{ $user->last_name . ', ' . $user->first_name }}
                                                </p>
                                                <p class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
                                                    {{ $user->role_position->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ $user->email }}
                                        </p>
                                    </td>
                                    <td class="text-center px-4">
                                        <p>
                                            {{ $user->edas->count() }}
                                        </p>
                                    </td>
                                    <td>
                                        <div
                                            class="p-1 w-fit text-left bg-neutral-50 flex text-sm items-center gap-1 rounded-lg border px-2">
                                            @if ($user->supervisor_id)
                                                @include('commons.avatar', [
                                                    'src' => $user->supervisor->profile,
                                                    'className' => 'w-8',
                                                    'alt' =>
                                                        $user->supervisor->first_name .
                                                        ' ' .
                                                        $user->supervisor->last_name,
                                                    'altClass' => 'text-md',
                                                ])
                                                <div>
                                                    <p class="text-nowrap">
                                                        {{ $user->supervisor->first_name }}
                                                    </p>
                                                    <p class="text-xs font-normal text-nowrap">
                                                        {{ $user->supervisor->role_position->name }}
                                                    </p>
                                                </div>
                                            @else
                                                -
                                            @endif
                                            </button>
                                    </td>
                                    <td>
                                        <p class="rounded-full p-2 hover:bg-neutral-200 transition-colors block">
                                            @svg('bx-chevron-right', 'w-5 h-5')
                                        </p>
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
