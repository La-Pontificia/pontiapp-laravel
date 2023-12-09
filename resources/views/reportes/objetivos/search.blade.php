<div class="relative">
    <div class="w-full relative">
        <svg class="w-5 absolute top-3 left-2 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
        <input type="text" value="{{ $colaborador ? $colaborador->nombres . ' ' . $colaborador->apellidos : null }}"
            autocomplete="off" id="search" class="w-full border-neutral-400 pl-8 rounded-lg"
            placeholder="Buscar y seleccionar colaboradores">
    </div>
    <div class="absolute w-full px-2 bg-white z-10 shadow-lg hidden rounded-xl mt-1 flex-col divide-y" id="list-colabs">
        <div class="p-10 grid place-content-center text-center text-neutral-400">
            <svg class="w-5 mx-auto text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
            Escribe un nombre o dni
        </div>
        <div class="flex justify-end">
            <button
                class="bg-neutral-200 min-w-max rounded-lg w-[100px] m-2 ml-auto border-neutral-400 border p-2 px-5">
                Cerrar
            </button>
        </div>
    </div>
</div>

@section('script')
    <script>
        const input = document.getElementById('search')
        const list = document.getElementById('list-colabs')
        const initialHtml = `<div class="p-10 grid place-content-center text-center text-neutral-400">
                            <svg class="w-5 mx-auto text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            Escribe un nombre o dni
                        </div>`


        input?.addEventListener('input', async function() {
            const q = this.value;
            if (q.trim() !== '') {
                list.classList.add('flex')
                list.classList.remove('hidden')
            } else {
                list.classList.add('hidden')
            }
            list.innerHTML = ``;
            const response = await axios.get(`/search-colaboradores?q=${q}`)

            response.data.forEach(function(colaborador) {
                const button = document.createElement('button');
                button.className = 'flex py-1 items-center gap-2';
                button.innerHTML =
                    `<span class="w-10 h-10 block overflow-hidden rounded-full">
                <img class="w-full h-full object-cover" src="${colaborador.perfil ?? '/profile-user.png'}" alt="">
            </span>
            <div class=" flex items-center gap-2">
                <h2 class="font-semibold">${colaborador.apellidos},${colaborador.nombres}</h2>
                <div class="font-normal bg-gray-800 p-[2px] rounded-xl px-3 text-white">${colaborador.dni}</div>
            </div>`;

                button.addEventListener('click', function() {
                    handleSelectChange(colaborador.id,
                        'colaborador'); // Agrega el parámetro 'colaborador'
                });

                list.appendChild(button);

                function handleSelectChange(id, paramName) {
                    var currentURL = window.location.href;
                    currentURL = currentURL.replace(/[?&]page(=([^&#]*)|&|#|$)/, '');
                    var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
                    if (regex.test(currentURL)) {
                        currentURL = currentURL.replace(new RegExp("([?&])" + paramName +
                                "=.*?(&|#|$)"), '$1' + paramName + '=' +
                            id + '$2');
                    } else {
                        currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' +
                            id; // Corrige la cadena
                    }
                    window.location.href = currentURL;
                }
            });


        });
    </script>
@endsection
