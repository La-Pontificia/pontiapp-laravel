@php
    $forList = [
        'collaborators' => 'Colaboradores',
        'supervisors' => 'Supervisores',
    ];
@endphp

<div>
    @if ($template)
        <input type="hidden" id="has-id" value="{{ $template->id }}">
    @endif
</div>

<div class="grid grid-cols-12 gap-4">
    <label class="flex flex-col col-span-5 font-normal text-sm">
        <span class="block pb-1">Título</span>
        <input name="title" value="{{ $template ? $template->title : '' }}" required
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1.5 px-2 rounded-lg">
    </label>
    <label class="flex flex-col col-span-6 font-normal text-sm">
        <span class="block pb-1">Cuestionario para</span>
        <select name="for" required type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($forList as $key => $value)
                <option {{ $template && $template->for === $key ? 'selected' : '' }} value="{{ $key }}">
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </label>
</div>

<div class="border-t overflow-x-auto flex flex-col overflow-y-auto">
    <button type="button" id="add-question-button"
        class="bg-neutral-200 w-fit mt-3 hover:bg-neutral-300 flex items-center gap-1 px-3 m-1 rounded-md p-2 text-sm font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-plus">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
        Agregar
    </button>
    <div class="overflow-auto" id="scroll-questions-table">
        <table class="w-full">
            <thead class="border-b">
                <tr class=" text-left [&>th]:font-medium text-sm [&>th]:p-2">
                    <th>Pregunta</th>
                    <th>Orden</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="questions-table" class="divide-y font-semibold">
                {{-- <tr class="">
                    <td>
                        <div aria-placeholder="Agrega la pregunta" class="min-h-[100px] text-indigo-700 w-[450px]"
                            contenteditable>
                            ¿Esta conforme con la valoracion de su supervisor?
                        </div>
                    </td>
                    <td class="p-1">
                        <input type="number"
                            class="bg-neutral-100 text-center w-12 border-2 border-neutral-400 p-1 px-2 rounded-lg"
                            value="1">
                    </td>
                    <td>
                        <button type="button"
                            class="bg-neutral-200 hover:bg-neutral-300 px-2 m-1 rounded-md p-2 text-sm font-semibold">
                            Remover
                        </button>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>
