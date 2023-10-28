import "./bootstrap";

import $ from "jquery";
window.jQuery = $;
window.$ = $;


document.addEventListener("DOMContentLoaded", function () {

    // --------------OBJETIVOS-----------
    const formcrear = document.getElementById("form-store-obj")
    const formactualizar = document.querySelectorAll(".form-update-obj");
    const botoneliminar = document.querySelectorAll('.delete-objetivo')
    const formautocalificar = document.querySelectorAll(".form-autocalificacion");

    // CREAR
    if (formcrear) {
        formcrear.addEventListener('submit', function (event) {
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
    }

    // ACTUALIZAR 
    if (formactualizar) {
        formactualizar.forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                axios.post(this.action, formData)
                    .then(function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Objetivo actualizado correctamente!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    })
                    .catch(function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la actualización del objetivo',
                            text: error.response.data.error,
                        });
                    });
            });
        });
    }

    // ELIMINAR
    if (botoneliminar) {
        botoneliminar.forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: '¿Estás seguro de eliminar el objetivo?',
                    text: 'No podrás deshacer esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = btn.dataset.id
                        axios.post(`/objetivos/delete/${id}`).then(res => {
                            location.reload();
                        }).catch(err => {
                            console.log(err)
                        })
                    }
                });
            })
        })
    }

    // AUTOCALIFICACION
    if (formautocalificar) {
        formautocalificar.forEach((form) => {
            form.addEventListener('submit', function (e) {
                e.preventDefault()
                e.stopPropagation()

                const id = this.dataset.id
                const nota = e.target.querySelector('select[name="nota"]').value;


                Swal.fire({
                    title: '¿Estás seguro de guardar la nota autocalificada?',
                    text: 'No podrás deshacer esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/objetivos/autocalificar`, {
                            nota,
                            id
                        }).then(() => {
                            window.location.reload()
                        }).catch((error) => {
                            alert(error)
                        })
                    }
                });
            })
        })
    }






    // --------EDA----------



    function mostrarConfirmacion(titulo, mensaje, estado, id, confirm_text) {
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: `Sí, ${confirm_text}`,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/eda_colaborador/cambiar_estado', {
                    id,
                    estado
                }).then(res => {
                    location.reload();
                }).catch(err => {
                    console.log(err.message);
                });
            }
        });
    }

    const botonenviareda = document.getElementById('enviar-eda-btn');
    const botonaprobareda = document.getElementById('aprobar-eda-btn');
    const botonautocalificareda = document.getElementById('autocalificar-eda-btn');

    if (botonenviareda) {
        botonenviareda.addEventListener('click', function () {
            const id = botonenviareda.dataset.id;
            mostrarConfirmacion('¿Estás seguro de enviar el EDA?', 'No podrás deshacer esta acción.', 1, id, 'enviar');
        });
    }

    if (botonaprobareda) {
        botonaprobareda.addEventListener('click', function () {
            const id = botonaprobareda.dataset.id;
            mostrarConfirmacion('¿Estás seguro de aprobar el EDA?', 'No podrás deshacer esta acción.', 2, id, 'aprobar');
        });
    }

    if (botonautocalificareda) {
        botonautocalificareda.addEventListener('click', function () {
            const id = botonautocalificareda.dataset.id;
            mostrarConfirmacion('¿Estás seguro de guardar y enviar los objetivos autocalificados?', 'No podrás deshacer esta acción.', 3, id, 'guardar y enviar');
        });
    }

});
