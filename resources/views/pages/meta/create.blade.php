@extends('layouts.meta')

@section('content-meta')
    @php
        $hasCreate = in_array('crear_eda', $colaborador_actual->privilegios);
    @endphp
    <div class="grid text-center gap-2 place-content-center p-10">
        <div class="w-48 mx-auto">
            <img src="/sad-2.png" alt="">
        </div>
        <h2 class="text-xl">EDA NO REGISTRADO</h2>
        <p class="text-neutral-400">Aun no se registró el eda del año {{ $eda->año }}</p>
        @if ($hasCreate)
            <button data-eda="{{ $eda->id }}" data-colab="{{ $colaborador->id }}" id="create"
                class="p-2 disabled:opacity-50 rounded-full bg-slate-800 text-neutral-300 font-semibold text-lg">
                Registrar ahora
            </button>
        @endif
    </div>
@endsection

@section('script')
    <script>
        const btn = document.getElementById('create')
        btn.addEventListener('click', async () => {
            const id_eda = btn.dataset.eda
            const id_colab = btn.dataset.colab
            try {
                btn.classList.add('animation-pulse');
                btn.disabled = true;
                btn.textContent = 'Creando...';
                const res = await axios.post('/eda_colab', {
                    id_eda,
                    id_colab
                })
            } catch (error) {
                console.log(error)
            } finally {
                location.reload();
            }
        })
    </script>
@endsection
