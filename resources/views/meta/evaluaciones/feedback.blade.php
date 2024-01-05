@if ($feedback)
    @php
        $califacion = $feedback->calificacion;
    @endphp
    <div class="p-6">
        <div
            class="h-[70px] block hover:scale-125 transition-all w-[70px] mx-auto peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
            @if ($califacion == 1)
                <img src="/emojis/1.png" alt="">
            @elseif($califacion == 2)
                <img src="/emojis/2.png" alt="">
            @else
                <img src="/emojis/3.png" alt="">
            @endif
        </div>
        <div>
            <p class="font-medium">{{ $feedback->feedback }}</p>
            <span class="text-sm opacity-50">Enviado el
                {{ $feedback->created_at->format('d \d\e F \d\e\l Y') }}</span>
            @if ($feedback->recibido && $feedback->fecha_recibido)
                <div class="text-sm opacity-50">Recibido el
                    {{ \Carbon\Carbon::parse($feedback->fecha_recibido)->format('d \d\e F \d\e\l Y') }}
                </div>
            @endif
        </div>
    </div>
@else
    <form data-id="{{ $id_evaluacion }}" data-eda="{{ $edaSeleccionado->id }}" id="form-create" class="p-6">
        <div id="number" class="flex gap-2 [&>label>div]:border [&>label]:cursor-pointer justify-center">
            <label for="calificacion-1">
                <input type="radio" id="calificacion-1" name="calificacion" value="1" class="hidden peer"
                    required>
                <div
                    class="h-[55px] w-[55px] block hover:scale-125 transition-all peer-checked:bg-yellow-100 peer-checked:border-0 p-1 rounded-full">
                    <img src="/emojis/1.png" alt="">
                </div>
            </label>
            <label for="calificacion-2">
                <input type="radio" id="calificacion-2" name="calificacion" value="2" class="hidden peer"
                    required>
                <div
                    class="h-[55px] w-[55px] block hover:scale-125 transition-all peer-checked:bg-yellow-100 peer-checked:border-0 p-1 rounded-full">
                    <img src="/emojis/2.png" alt="">
                </div>
            </label>
            <label for="calificacion-3">
                <input type="radio" checked id="calificacion-3" name="calificacion" value="3" class="hidden peer"
                    required>
                <div
                    class="h-[55px] w-[55px] block hover:scale-125 transition-all peer-checked:bg-yellow-100 peer-checked:border-0 p-1 rounded-full">
                    <img src="/emojis/3.png" alt="">
                </div>
            </label>
        </div>
        <div class="mt-5">
            <label for="feedback">¿Qué característica puede agregar para que mejore?</label>
            <textarea id="feedback" name="feedback" class="rounded-xl resize-none text-base font-medium w-full border-neutral-300"
                name="" placeholder="Nos encantaría escuchar tus sugerencias." rows="4"></textarea>
        </div>
        <button class="w-full h-10 bg-blue-700 rounded-xl text-white font-medium">
            Enviar feedback
        </button>
    </form>
@endif

<script>
    // ----------- FEEDBACK ---------------

    const form = document.getElementById('form-create')
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id_eva = form.dataset.id;
        const id_eda = form.dataset.eda;

        const feedback = e.target.querySelector('textarea[name="feedback"]').value;
        const calificacion = e.target.querySelector('input[name="calificacion"]:checked').value;

        try {
            const res = await axios.post(`/meta/feedback`, {
                feedback,
                calificacion,
                id_eva,
                id_eda
            })

            Swal.fire({
                icon: 'success',
                title: '¡Feedback enviado correctamente!',
            }).then(() => {
                location.reload();
            });

        } catch (error) {
            console.log(error)
        }

    })
</script>
