<div class="box-body grid grid-cols-2 gap-2">
    <span>
        <input required name="flimit_send_obj_from" type="date" pattern="\d{4}"
            value="{{ \Carbon\Carbon::parse($currentColabEda->flimit_send_obj_from)->format('Y-m-d') }}" placeholder="Año"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
    </span>

    <span>
        <input required name="flimit_send_obj_at" type="date"
            value="{{ \Carbon\Carbon::parse($currentColabEda->flimit_send_obj_at)->format('Y-m-d') }}"
            placeholder="F. fin"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
    </span>
    <span>
        <input name="id" type="hidden" value="{{ $currentColabEda->id }}">
    </span>
</div>
