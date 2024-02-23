import "./bootstrap";
import "./commons";
import "./reportes/colaboradores";
import "./reportes/edas";
import "./filters-combobox";
import "./profile";
import "./colaboradores";
import "./evaluaciones";

import $ from "jquery";
window.jQuery = $;
window.$ = $;

const Toast = Swal.mixin({
    toast: true,
    position: "bottom-left",
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
});

document.addEventListener("DOMContentLoaded", function () {
    // --------------OBJETIVOS-----------
    const formcrear = document.getElementById("form-store-obj");
    const formactualizar = document.querySelectorAll(".form-update-obj");
    const botoneliminar = document.querySelectorAll(".delete-objetivo");
    const formautocalificar = document.querySelectorAll(
        ".form-autocalificacion"
    );
    const formacalificacion = document.querySelectorAll(".form-calificacion");
    const btnfeedbackpreview = document.getElementById("btn-feedback-preview");
    const btncerrareva = document.getElementById("btn-cerrar-eva");

    const btncerrareda = document.getElementById("btn-cerrar-eda");
    const btneliminareda = document.getElementById("btn-eliminar-eda");

    const abrirevaluacion = document.getElementById("abrir-evaluacion");

    // CREAR
    if (formcrear) {
        formcrear.addEventListener("submit", function (event) {
            event.preventDefault();
            // Serializa el formulario
            const formData = new FormData(this);
            axios
                .post(this.action, formData)
                .then(function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "¡Objetivo creado correctamente!",
                    }).then(() => {
                        window.location.href = window.location.href;
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error al crear el objetivo",
                        text: error.response.data.error,
                    });
                });
        });
    }

    // ACTUALIZAR
    if (formactualizar) {
        formactualizar.forEach((form) => {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                axios
                    .post(this.action, formData)
                    .then(function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Objetivo actualizado correctamente!",
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error en la actualización del objetivo",
                            text: error.response.data.error,
                        });
                    });
            });
        });
    }

    // ELIMINAR
    if (botoneliminar) {
        botoneliminar.forEach((btn) => {
            btn.addEventListener("click", () => {
                Swal.fire({
                    title: "¿Estás seguro de eliminar el objetivo?",
                    text: "No podrás deshacer esta acción.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = btn.dataset.id;
                        axios
                            .post(`/meta/objetivos/${id}`)
                            .then((res) => {
                                location.reload();
                            })
                            .catch((err) => {
                                console.log(err);
                            });
                    }
                });
            });
        });
    }

    // AUTOCALIFICACION
    if (formautocalificar) {
        formautocalificar.forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                e.stopPropagation();

                const id = this.dataset.id;
                const eva = this.dataset.eva;

                const nota = e.target.querySelector(
                    'select[name="nota"]'
                ).value;

                Swal.fire({
                    title: "¿Estás seguro de guardar la nota autocalificada?",
                    text: "No podrás deshacer esta acción.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, guardar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(`/meta/objetivos/autocalificar/${eva}`, {
                                nota,
                                id,
                            })
                            .then(() => {
                                window.location.reload();
                            })
                            .catch((error) => {
                                alert(error);
                            });
                    }
                });
            });
        });
    }

    // CALIFICACION
    if (formacalificacion) {
        formacalificacion.forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                e.stopPropagation();

                const id = this.dataset.id;
                const eva = this.dataset.eva;
                const nota = e.target.querySelector(
                    'select[name="nota"]'
                ).value;

                Swal.fire({
                    title: "¿Estás seguro de guardar la nota calificada?",
                    text: "No podrás deshacer esta acción.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, guardar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(`/meta/objetivos/calificar/${eva}`, {
                                nota,
                                id,
                            })
                            .then(() => {
                                window.location.reload();
                            })
                            .catch((error) => {
                                alert(error);
                            });
                    }
                });
            });
        });
    }

    // --------EDA----------

    function mostrarConfirmacion(titulo, mensaje, estado, id, confirm_text) {
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: `Sí, ${confirm_text}`,
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                const URL = `/eda_colab/${estado}/${id}`;
                axios
                    .post(URL, {
                        estado,
                    })
                    .then((res) => {
                        location.reload();
                    })
                    .catch((err) => {
                        console.log(err.message);
                    });
            }
        });
    }

    const botonenviareda = document.getElementById("enviar-eda-btn");
    const botonaprobareda = document.getElementById("aprobar-eda-btn");
    const botonautocalificareda = document.getElementById(
        "autocalificar-eda-btn"
    );

    if (botonenviareda) {
        botonenviareda.addEventListener("click", function () {
            const id = botonenviareda.dataset.id;
            mostrarConfirmacion(
                "¿Estás seguro de enviar el EDA?",
                "No podrás deshacer esta acción.",
                "enviar",
                id,
                "enviar"
            );
        });
    }

    if (botonaprobareda) {
        botonaprobareda.addEventListener("click", function () {
            const id = botonaprobareda.dataset.id;
            mostrarConfirmacion(
                "¿Estás seguro de aprobar el EDA?",
                "No podrás deshacer esta acción.",
                "aprobar",
                id,
                "aprobar"
            );
        });
    }

    if (btneliminareda) {
        btneliminareda.addEventListener("click", function () {
            const id = btneliminareda.dataset.id;
            mostrarConfirmacion(
                "¿Estás seguro de eliminar el EDA?",
                "Se eliminará los objetivos, evaluaciones, cuestionarios. No podrás deshacer esta acción.",
                "eliminar",
                id,
                "aprobar"
            );
        });
    }

    if (botonautocalificareda) {
        botonautocalificareda.addEventListener("click", function () {
            const id = botonautocalificareda.dataset.id;
            mostrarConfirmacion(
                "¿Estás seguro de guardar y enviar los objetivos autocalificados?",
                "No podrás deshacer esta acción.",
                "autocalificado",
                id,
                "guardar y enviar"
            );
        });
    }

    // cerrar

    if (btncerrareda) {
        btncerrareda.addEventListener("click", function () {
            const id = btncerrareda.dataset.id;
            Swal.fire({
                title: "¿Estas seguro de cerrar el EDA?",
                text: "No podras deshacer esta acción",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `Sí, cerrar`,
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(`/eda/cerrar/${id}`)
                        .then((res) => {
                            location.reload();
                        })
                        .catch((err) => {
                            console.log(err.message);
                        });
                }
            });
        });
    }

    // --------------EVALUACIONES

    // cerrar eva
    if (btncerrareva) {
        btncerrareva.addEventListener("click", function () {
            const id = btncerrareva.dataset.id;
            const id_eda = btncerrareva.dataset.eda;
            const n_eva = btncerrareva.dataset.neva;

            Swal.fire({
                title: "¿Estás seguro de guardar y cerrar esta evaluación?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `Sí, cerrar`,
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            `/meta/evaluaciones/cerrar/${id}/${id_eda}/${n_eva}`
                        )
                        .then((res) => {
                            location.reload();
                        })
                        .catch((err) => {
                            console.log(err.message);
                        });
                }
            });
        });
    }

    // abrir evaluacion

    if (abrirevaluacion) {
        abrirevaluacion.addEventListener("click", function () {
            const id = abrirevaluacion.dataset.id;

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Abrir la evaluación",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `Sí, abrir`,
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post(`/meta/evaluaciones/abrir/${id}`);
                        location.reload();
                    } catch (error) {
                        console.log(error.message);
                    }
                }
            });
        });
    }

    // create received feedback
    if (btnfeedbackpreview) {
        btnfeedbackpreview.addEventListener("click", function () {
            const id_feedback = btnfeedbackpreview.dataset.id;
            axios
                .post(`/meta/feedback/received/${id_feedback}`)
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err);
                });
        });
    }

    // --------------------------------ACCESOS

    const toggleaccess = document.querySelectorAll(".toggle-access");

    toggleaccess.forEach((toggleinput) => {
        toggleinput.addEventListener("change", function (e) {
            e.preventDefault();
            const isChecked = toggleinput.checked;
            const name = toggleinput.name;
            const dataId = toggleinput.dataset.id;
            axios
                .post(`/accesos/cambiar/${dataId}`, {
                    name,
                    value: isChecked,
                })
                .then((res) => {
                    Toast.fire({
                        icon: "success",
                        title: "Cambiado correctamente",
                    });
                })
                .catch((err) => {
                    console.log(err.message);
                });
        });
    });

    //
});
