@extends('modules.users.+layout')

@section('title', 'Registrar nuevo rol de usuario')


@section('layout.users')
    <div class="max-w-6xl mx-auto">
        <form role="form" id="user-role-form" class="p-3 grid gap-3" enctype="multipart/form-data">
            <label>
                <span>Título del rol:</span>
                <input required type="text" name="title" placeholder="Ejemplo: Administrador">
            </label>
            <div>
                <p class="py-4 font-semibold tracking-tight text-sm text-stone-600">Privilegios:</p>
                <div class="grid gap-5 grid-cols-3 max-xl:grid-cols-2 items-start">
                    @foreach ($system_privileges as $system_privilege)
                        <div class="border border-transparent">
                            <div class="flex mb-4 items-center gap-2">
                                <button type="button" class="toggle-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(90deg);" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>
                                <label class="flex items-center gap-2 font-semibold">
                                    <input type="checkbox" class="select-all-group rounded-md p-2.5 border-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-file">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                    </svg>
                                    <span>{{ $system_privilege['name'] }}</span>
                                </label>
                            </div>
                            <div class="group-content grid gap-2 mt-2">
                                @foreach ($system_privilege['items'] as $item)
                                    <div class="border border-neutral-200 bg-white p-2 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="toggle-subgroup">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-chevron-right">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                            <label class="flex items-center gap-2 font-semibold">
                                                <input type="checkbox"
                                                    class="select-all-subgroup rounded-md p-2.5 border-neutral-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-file">
                                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                                </svg>
                                                <span>{{ $item['name'] }}</span>
                                            </label>
                                            <span class="privilege-count text-sm text-gray-500">(0/0)</span>
                                        </div>
                                        <div class="subgroup-content mt-4 grid pl-10 gap-3" style="display: none;">
                                            @foreach ($item['privileges'] as $privilege => $privilege_name)
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" name="privileges[]" value="{{ $privilege }}"
                                                        class="privilege-checkbox rounded-md p-2.5 border-neutral-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-file">
                                                        <path
                                                            d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                                    </svg>
                                                    <span>{{ $privilege_name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                    Registrar
                </button>
            </div>
        </form>
    </div>
@endsection
