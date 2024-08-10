@php
    $forList = [
        'collaborators' => 'Colaboradores',
        'supervisors' => 'Supervisores',
    ];

    $title = isset($template) ? $template->title : 'Plantilla de cuestionario';

@endphp

<div class="p-4 pb-2">
    @if (isset($template))
        <input type="hidden" id="template_id" value="{{ $template->id }}">
    @endif
    <div class="grid relative grid-cols-12 gap-4 max-w-xl ">
        <label class="flex flex-col col-span-5 font-normal">
            <span class="block pb-1">Título</span>
            <input name="title" value="{{ $title }}" required>
        </label>
        <label class="flex flex-col col-span-6 font-normal">
            <span class="block pb-1">Cuestionario para</span>
            <select name="for" required>
                @foreach ($forList as $key => $value)
                    <option {{ isset($template) && $template->for === $key ? 'selected' : '' }}
                        value="{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </label>
    </div>
</div>

<div class="p-4 pt-0">
    <div class="bg-white rounded-xl shadow-md border flex flex-col overflow-y-auto">
        <button type="button" id="add-question-button"
            class="bg-white border hover:border-neutral-300 w-fit mt-3 flex items-center gap-1 px-3 m-1 rounded-full p-2 text-sm font-semibold">
            @svg('heroicon-o-plus', [
                'class' => 'w-5 h-5',
            ])
            Agregar
        </button>

        <template id="question-template">
            <tr class="[&>td]:py-3 font-normal item [&>td]:align-top hover:[&>td]shadow-md relative group [&>td]:px-2">
                <td>
                    <button class="inner-handle p-2" type="button">
                        @svg('heroicon-o-equals', [
                            'class' => 'w-5 h-5',
                        ])
                    </button>
                </td>
                <td>
                    <div contenteditable="true" class="question min-h-16 p-1 h-full">

                    </div>
                </td>
                <td>
                    <button type="button" title="Eliminar pregunta"
                        class="p-1 flex delete items-center gap-2 text-white bg-orange-600 text-sm rounded-lg px-2">
                        @svg('heroicon-o-trash', [
                            'class' => 'w-5 h-5',
                        ])
                    </button>
                </td>
            </tr>
        </template>

        <div class="overflow-auto flex-grow" id="scroll-questions-table">
            <table class="w-full">
                <thead class="border-b">
                    <tr class=" text-left [&>th]:font-medium text-sm [&>th]:p-1">
                        <th></th>
                        <th class="w-full"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="questions" class="divide-y sortable font-semibold">

                </tbody>
            </table>
        </div>
    </div>
</div>

@if (isset($template))
    <div id="loader" class="absolute grid rounded-xl place-content-center h-full inset-0 bg-white z-10">
        <div class="loader"></div>
    </div>
@endif
