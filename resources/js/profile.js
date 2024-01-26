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