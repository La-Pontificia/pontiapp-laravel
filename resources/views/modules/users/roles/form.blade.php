@php
    $privileges = $role ? $role->privileges : [];
@endphp
<label class="w-[300px] block px-1 pb-4">
    <span>Título:</span>
    <input value="{{ $role ? $role->title : '' }}" required type="text" name="title"
        placeholder="Ejemplo: Administrador" class="font-medium">
</label>
<div class="px-1 overflow-y-auto">
    <p class="py-4 pt-1 font-semibold tracking-tight text-sm text-stone-600">Privilegios:</p>
    <div class="grid gap-5 grid-cols-3 max-xl:grid-cols-2 items-start">
        @foreach ($system_privileges as $system_privilege)
            <div class="border border-transparent">
                <div class="flex mb-4 items-center gap-2">
                    <button type="button" class="toggle-group">
                        <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(90deg);" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <label class="flex items-center gap-2 font-semibold">
                        <input type="checkbox" class="select-all-group rounded-md p-2.5 border-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-file">
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
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>
                                <label class="flex items-center gap-2 font-semibold">
                                    <input type="checkbox"
                                        class="select-all-subgroup rounded-md p-2.5 border-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-file">
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
                                        <input {{ in_array($privilege, $privileges) ? 'checked' : '' }} type="checkbox"
                                            name="privileges[]" value="{{ $privilege }}"
                                            class="privilege-checkbox rounded-md p-2.5 border-neutral-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-file">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
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
