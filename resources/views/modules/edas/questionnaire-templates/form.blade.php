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
    <label class="label">
        <span>Título</span>
        <input name="title" value="{{ $title }}" required>
    </label>
</div>


<div class="flex flex-col overflow-y-auto">
    <template id="question-template">
        <tr class="[&>td]:py-3 font-normal item [&>td]:align-top hover:[&>td]shadow-md relative group [&>td]:px-2">
            <td>
                <button class="inner-handle p-2" type="button">
                    svg'heroicon-o-equals', [
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
                    svg'bx-x', 'w-5 h-5')
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

<div class="relative p-4 py-2">
    <button type="button" id="add-question-button" class="secondary" style="padding-block: 2px">
        svg'bx-plus', 'w-5 h-5')
        Agregar pregunta
    </button>
</div>

@if (isset($template))
    <div id="loader" class="absolute grid rounded-xl place-content-center h-full inset-0 bg-white z-10">
        <div class="loader"></div>
    </div>
@endif
