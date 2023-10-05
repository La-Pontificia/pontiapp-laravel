import "./bootstrap";

import $ from "jquery";
window.jQuery = $;
window.$ = $;


document.addEventListener("DOMContentLoaded", function () {
    // OBJETIVOS

    const $btndeleteobj = document.getElementById("btn-delete-obj")
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

    // // UPDATE
    // $formeobjupdate.addEventListener('submit', function (event) {
    //     event.preventDefault();
    //     const formData = new FormData(this);
    //     axios.post(this.action, formData)
    //         .then(function (response) {
    //             console.log(response.data)
    //             if (response.data.message) {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error en la actualizacion del objetivo',
    //                     text: response.data.message,
    //                 });
    //             } else if (response.data.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: '¡Objetivo actualizado correctamente!',
    //                 }).then(() => {
    //                     window.location.href = window.location.href;
    //                 });
    //             }
    //         })
    //         .catch(function (error) {
    //             console.log(error)
    //         });
    // });

    // DELETE
    $btndeleteobj.addEventListener('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás deshacer esta acción.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-{{ $objetivo->id }}').submit();
            }
        });
    })


});
