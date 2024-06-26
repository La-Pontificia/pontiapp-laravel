<div id="change-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow :bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center :hover:bg-gray-600 :hover:text-white"
                data-modal-hide="change-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 :text-white">Cambiar contraseña</h3>
                <form id="form-change-password" class="flex flex-col gap-2">
                    <label for="current_password">
                        <span class="font-normal px-1 opacity-70">Contraseña actual:</span>
                        <input id="current_password" type="password" name="current_password"
                            class="p-3 w-full rounded-full px-4">
                    </label>
                    <label for="new_password">
                        <span class="font-normal px-1 opacity-70">Nueva contraseña:</span>
                        <input id="new_password" type="password" name="new_password"
                            class="p-3 w-full rounded-full px-4">
                    </label>
                    <label for="repeat_password">
                        <span class="font-normal px-1 opacity-70">Repite la nueva contraseña:</span>
                        <input id="repeat_password" type="password" name="repeat_password"
                            class="p-3 w-full rounded-full px-4">
                    </label>
                    <button
                        class="text-white bg-rose-700 rounded-3xl font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
