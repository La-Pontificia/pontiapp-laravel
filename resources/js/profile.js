const changePasswordForm = document.getElementById('form-change-password');

function validatePassword() {
    var newPassword = document.getElementById('new_password').value;
    var repeatPassword = document.getElementById('repeat_password').value;
    var current_password = document.getElementById('current_password').value;

    if (newPassword !== repeatPassword) {
        Swal.fire({
            icon: 'info',
            title: 'Las contraseñas no coinciden.',
            text: 'Las contraseñas no coinciden.',
        })
        return false;
    }

    if (newPassword.length < 6) {
        Swal.fire({
            icon: 'info',
            title: 'Invalido',
            text: 'La nueva contraseña debe tener al menos 6 caracteres.',
        })
        return false;
    }

    if (current_password.length < 6) {
        Swal.fire({
            icon: 'info',
            title: 'Invalido',
            text: 'La contraseña actual no puede estar vacio',
        })
        return false;
    }

    return true;
}

changePasswordForm.addEventListener('submit', async (event) => {
    event.preventDefault()
    if (validatePassword()) {
        const formData = new FormData(changePasswordForm);
        try {
            const res = await axios.post('/change-password', formData)
            Swal.fire({
                icon: 'info',
                title: 'Actualizado',
                text: 'Contraseña actualizada correctamente',
            }).then(() => {
                location.reload()
            })
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.response.data.error,
            })

        }

    }
})



const upload = document.getElementById('upload');
const imagePreview = document.getElementById('image-preview');
const input = document.getElementById('imageInput');
const btnChangeImage = document.getElementById('btnchangeimage');

btnChangeImage.addEventListener('click', function () {
    input.click();
    console.log('click')
});

input.addEventListener('change', function () {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            upload.style.display = 'inline-block';
        };
        reader.readAsDataURL(input.files[0]);
    }
});

upload.addEventListener(('click'), async function (event) {
    const cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dc0t90ahb/upload';
    const input = document.getElementById('imageInput');
    const file = input.files[0];

    if (!file) return

    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', 'ztmbixcz');
    try {
        upload.classList.add('animation-pulse');
        upload.disabled = true;
        upload.textContent = 'Actualizando...';
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