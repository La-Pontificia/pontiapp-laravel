import "./bootstrap";

import $ from "jquery";
window.jQuery = $;
window.$ = $;


document.addEventListener("DOMContentLoaded", function () {
    // const $formeobjupdate = document.getElementById("form-update-obj")
    const $formobjustore = document.getElementById("form-store-obj")


    // STORE 
    $formobjustore.addEventListener('submit', function (event) {
        event.preventDefault();
        // Serializa el formulario
        const formData = new FormData(this);
        axios.post(this.action, formData)
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Objetivo creado correctamente!',
                }).then(() => {
                    window.location.href = window.location.href;
                });
            })
            .catch(function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al crear el objetivo',
                    text: error.response.data.error,
                });
            });
    });

});
