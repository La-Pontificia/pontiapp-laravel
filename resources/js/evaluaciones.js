const guardarAutocalificacion = document.getElementById(
    "guardar-autocalificacion_eva"
);
if (guardarAutocalificacion) {
    guardarAutocalificacion.addEventListener("click", () => {
        const tableRows = document.querySelectorAll(
            "#table-body-list-autocalificacion tr"
        );
        let allSelectsSelected = true;

        tableRows.forEach((row) => {
            const selectElement = row.querySelector('select[name="nota"]');
            const autocalificacion = selectElement.value;
            if (autocalificacion === "") allSelectsSelected = false;
        });

        if (allSelectsSelected) {
            const autocalificacionArray = [];
            tableRows.forEach((row) => {
                const selectElement = row.querySelector('select[name="nota"]');
                const objetivoId = selectElement.dataset.id;
                const autocalificacion = selectElement.value;
                autocalificacionArray.push({
                    id: objetivoId,
                    autocalificacion: autocalificacion,
                });
            });

            const idEda = guardarAutocalificacion.dataset.id;
            const n_eva = guardarAutocalificacion.dataset.eva;

            Swal.fire({
                title: "¿Estás seguro de guardar las notas autocalificadas?",
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
                        .post("/objetivos/autocalificar", {
                            autocalificacionArray,
                            n_eva,
                        })
                        .then((res) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            });
        } else {
            Swal.fire({
                icon: "info",
                title: "Autocalificación incompleta",
                text: "Todos los objetivos tienen que estar autocalificados, por favor vuelve a intentarlo.",
            });
        }
    });
}

const guardarCalificacion = document.getElementById("guardar-calificacion_eva");

if (guardarCalificacion) {
    guardarCalificacion.addEventListener("click", () => {
        const tableRows = document.querySelectorAll(
            "#table-body-list-calificacion tr"
        );
        let allSelectsSelected = true;

        tableRows.forEach((row) => {
            const selectElement = row.querySelector('select[name="nota"]');
            const autocalificacion = selectElement.value;
            if (autocalificacion === "") allSelectsSelected = false;
        });

        if (allSelectsSelected) {
            const califacionArray = [];
            tableRows.forEach((row) => {
                const selectElement = row.querySelector('select[name="nota"]');
                const objetivoId = selectElement.dataset.id;
                const autocalificacion = selectElement.value;
                califacionArray.push({
                    id: objetivoId,
                    autocalificacion: autocalificacion,
                });
            });

            const idEda = guardarCalificacion.dataset.id;
            const n_eva = guardarCalificacion.dataset.eva;

            Swal.fire({
                title: "¿Estás seguro de guardar las notas calificadas?",
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
                        .post(`/objetivos/calificar`, {
                            califacionArray,
                            n_eva,
                        })
                        .then((res) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            alert(error);
                        });
                }
            });
        } else {
            Swal.fire({
                icon: "info",
                title: "Calificación incompleta",
                text: "Todos los objetivos tienen que estar calificados, por favor vuelve a intentarlo.",
            });
        }
    });
}
