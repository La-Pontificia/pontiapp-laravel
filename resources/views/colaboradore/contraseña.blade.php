<div id="contraseña-modal-{{ $colaborador->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative max-w-md w-full max-h-full">
        <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="contraseña-modal-{{ $colaborador->id }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
            <div class="px-4 py-4">
                <h3 class="mb-4 text-xl font-medium text-gray-900">
                    Cambiar contraseña
                </h3>
                <span class="w-32 mx-auto h-32 block overflow-hidden rounded-full">
                    <img class="w-full h-full object-cover"
                        src={{ $colaborador->perfil ? $colaborador->perfil : '/profile-user.png' }} alt="">
                </span>
                @if (!$is_dev)
                    <h2 class="text-black text-xl font-bold text-center py-2"> {{ $colaborador->nombres }}</h2>
                    <form action="/colaboradores/cambiar-clave/{{ $colaborador->id }}"
                        class="flex change-password flex-col gap-2">
                        <div>
                            <label for="password">Nueva contraseña</label>
                            <input type="text" id="password" required name="password"
                                placeholder="Ingrese la nueva contraseña" pattern=".{5,}"
                                title="La contraseña debe tener al menos 5 caracteres"
                                class="p-3 w-full rounded-full px-4">
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Guardar</button>
                    </form>
                @else
                    <div class="p-5 text-center">
                        No se puede cambiar la contraseña de un desarrollador
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
