@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="flex flex-col">
        <header class="h-full border rounded-3xl shadow-lg">
            <div class="w-full p-3">
                <div class="flex relative group min-w-[6rem] h-[6rem] w-[6rem] border overflow-hidden rounded-full"">
                    <img id="image-preview" alt="{{ $colaborador->nombres }}"
                        src={{ $colaborador->perfil ? $colaborador->perfil : '/profile-user.png' }}
                        class="w-full h-full object-cover">
                    @if ($miPerfil && !$suSupervisor)
                        <span id="btnchangeimage"
                            class="absolute group-hover:opacity-100 opacity-0 cursor-pointer inset-0 bg-white/80 grid place-content-center">
                            <svg class="w-10 opacity-60" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.59843 4.48666C7.86525 3.17678 9.03088 2.25 10.3663 2.25H13.6337C14.9691 2.25 16.1347 3.17678 16.4016 4.48666C16.4632 4.78904 16.7371 5.01086 17.022 5.01086H17.0384L17.0548 5.01157C18.4582 5.07294 19.5362 5.24517 20.4362 5.83558C21.0032 6.20757 21.4909 6.68617 21.871 7.24464C22.3439 7.93947 22.5524 8.73694 22.6524 9.70145C22.75 10.6438 22.75 11.825 22.75 13.3211V13.4062C22.75 14.9023 22.75 16.0835 22.6524 17.0258C22.5524 17.9903 22.3439 18.7878 21.871 19.4826C21.4909 20.0411 21.0032 20.5197 20.4362 20.8917C19.7327 21.3532 18.9262 21.5567 17.948 21.6544C16.9903 21.75 15.789 21.75 14.2634 21.75H9.73657C8.21098 21.75 7.00967 21.75 6.05196 21.6544C5.07379 21.5567 4.26731 21.3532 3.56385 20.8917C2.99682 20.5197 2.50905 20.0411 2.12899 19.4826C1.65612 18.7878 1.44756 17.9903 1.34762 17.0258C1.24998 16.0835 1.24999 14.9023 1.25 13.4062V13.3211C1.24999 11.825 1.24998 10.6438 1.34762 9.70145C1.44756 8.73694 1.65612 7.93947 2.12899 7.24464C2.50905 6.68617 2.99682 6.20757 3.56385 5.83558C4.46383 5.24517 5.5418 5.07294 6.94523 5.01157L6.96161 5.01086H6.978C7.26288 5.01086 7.53683 4.78905 7.59843 4.48666ZM10.3663 3.75C9.72522 3.75 9.18905 4.19299 9.06824 4.78607C8.87258 5.74659 8.021 6.50186 6.99633 6.51078C5.64772 6.57069 4.92536 6.73636 4.38664 7.08978C3.98309 7.35452 3.63752 7.6941 3.36906 8.08857C3.09291 8.49435 2.92696 9.01325 2.83963 9.85604C2.75094 10.7121 2.75 11.8156 2.75 13.3636C2.75 14.9117 2.75094 16.0152 2.83963 16.8712C2.92696 17.714 3.09291 18.2329 3.36906 18.6387C3.63752 19.0332 3.98309 19.3728 4.38664 19.6375C4.80417 19.9114 5.33844 20.0756 6.20104 20.1618C7.07549 20.2491 8.20193 20.25 9.77778 20.25H14.2222C15.7981 20.25 16.9245 20.2491 17.799 20.1618C18.6616 20.0756 19.1958 19.9114 19.6134 19.6375C20.0169 19.3728 20.3625 19.0332 20.6309 18.6387C20.9071 18.2329 21.073 17.714 21.1604 16.8712C21.2491 16.0152 21.25 14.9117 21.25 13.3636C21.25 11.8156 21.2491 10.7121 21.1604 9.85604C21.073 9.01325 20.9071 8.49435 20.6309 8.08857C20.3625 7.6941 20.0169 7.35452 19.6134 7.08978C19.0746 6.73636 18.3523 6.57069 17.0037 6.51078C15.979 6.50186 15.1274 5.74659 14.9318 4.78607C14.8109 4.19299 14.2748 3.75 13.6337 3.75H10.3663ZM12 10.75C10.7574 10.75 9.75 11.7574 9.75 13C9.75 14.2426 10.7574 15.25 12 15.25C13.2426 15.25 14.25 14.2426 14.25 13C14.25 11.7574 13.2426 10.75 12 10.75ZM8.25 13C8.25 10.9289 9.92893 9.25 12 9.25C14.0711 9.25 15.75 10.9289 15.75 13C15.75 15.0711 14.0711 16.75 12 16.75C9.92893 16.75 8.25 15.0711 8.25 13ZM17.25 10C17.25 9.58579 17.5858 9.25 18 9.25H19C19.4142 9.25 19.75 9.58579 19.75 10C19.75 10.4142 19.4142 10.75 19 10.75H18C17.5858 10.75 17.25 10.4142 17.25 10Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="file" hidden id="imageInput" accept="image/*" />
                    @endif
                </div>
                <h3 class="text-lg pt-2 font-semibold capitalize text-gray-900">
                    {{ $colaborador->nombres }}
                    {{ $colaborador->apellidos }}
                </h3>
                <div class="flex flex-col">
                    <div class="text-gray-500 capitalize flex gap-1">
                        {{ mb_strtolower($colaborador->cargo->puesto->nombre, 'UTF-8') }}
                        -
                        {{ mb_strtolower($colaborador->cargo->departamento->area->nombre, 'UTF-8') }}
                    </div>
                </div>
            </div>
            @include('meta.edas')
        </header>
        <div class="w-full">
            @yield('content-meta')
        </div>
    </div>
@endsection



@section('script')
    <script>
        const uploadImage = document.getElementById('uploadimage');
        const imagePreview = document.getElementById('image-preview');
        const input = document.getElementById('imageInput');
        const btnChangeImage = document.getElementById('btnchangeimage');

        btnChangeImage.addEventListener('click', function() {
            input.click();
        });

        input.addEventListener('change', function() {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    uploadImage.style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
        uploadImage.addEventListener(('click'), async function(event) {
            const cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dc0t90ahb/upload';
            const input = document.getElementById('imageInput');
            const file = input.files[0];

            if (!file) return

            const formData = new FormData();
            formData.append('file', file);
            formData.append('upload_preset', 'ztmbixcz');
            try {
                const response = await axios.post(cloudinaryUrl, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                const responseChange = await axios.post('/colaboradores/cambiar-perfil', {
                    url: response.data.secure_url
                })

                location.reload()

            } catch (error) {

                console.error('Error al subir la imagen a Cloudinary:', error.message);
                throw error;

            }
        })
    </script>
@endsection
