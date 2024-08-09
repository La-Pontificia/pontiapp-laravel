import axios from "axios";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const $table = $("#evaluations");
    const $selfQualify = $("#evaluation-self-qualify-button");
    const $qualify = $("#evaluation-qualify-button");
    const $close = $("#evaluation-close-button");

    const $totalSelfQualification = $("#total-self-qualification");
    const $totalQualification = $("#total-qualification");
    const $rows = Array.from($table?.querySelectorAll("tr") ?? []);

    function getTotalSelfQualification() {
        const total = $rows.reduce((acc, $row) => {
            const percentage =
                $row
                    .querySelector(".percentage")
                    ?.getAttribute("data-percentage") || 0;

            const selfQualification =
                $row.querySelector(".self-qualification")?.value || 0;

            return acc + (Number(selfQualification) * Number(percentage)) / 100;
        }, 0);
        return total;
    }

    function getTotalQualification() {
        const total = $rows.reduce((acc, $row) => {
            const percentage =
                $row
                    .querySelector(".percentage")
                    ?.getAttribute("data-percentage") || 0;

            const qualification =
                $row.querySelector(".qualification")?.value || 0;

            return acc + (Number(qualification) * Number(percentage)) / 100;
        }, 0);
        return total;
    }

    function getItems() {
        const items = $rows.map(($row) => {
            const id = $row.getAttribute("data-id");
            const selfQualification = $row.querySelector(
                ".self-qualification"
            )?.value;
            const qualification = $row.querySelector(".qualification")?.value;
            return {
                id,
                self_qualification: Number(selfQualification),
                qualification: Number(qualification),
            };
        });
        return items;
    }

    $rows?.forEach(($row) => {
        const $selfQualificationSelect = $row.querySelector(
            ".self-qualification"
        );
        const $qualificationSelect = $row.querySelector(".qualification");

        $selfQualificationSelect?.addEventListener("change", async (e) => {
            $totalSelfQualification.innerHTML = getTotalSelfQualification();
        });

        $qualificationSelect?.addEventListener("change", async (e) => {
            $totalQualification.innerHTML = getTotalQualification();
        });
    });

    $selfQualify?.addEventListener("click", () => {
        const id = $selfQualify.getAttribute("data-id");
        void qualify(id, getTotalSelfQualification(), getItems());
    });

    $qualify?.addEventListener("click", () => {
        const id = $qualify.getAttribute("data-id");
        void qualify(id, getTotalQualification(), getItems(), false);
    });

    async function qualify(id, total, items, selfQualify = true) {
        if (total == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: `La ${
                    selfQualify ? "autocalificación" : "calificación"
                } total no puede ser 0`,
            });
            return;
        }
        try {
            const result = await Swal.fire({
                title: `¿Estás seguro de finalizar la ${
                    selfQualify ? "autocalificación" : "calificación"
                } de los objetivos?`,
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `Sí, ${
                    selfQualify ? "autocalificar" : "calificar"
                }`,
                cancelButtonText: "Cancelar",
            });
            if (!result.isConfirmed) return;

            const { data } = await axios.post(
                `/api/evaluations/${
                    selfQualify ? "self-qualify" : "qualify"
                }/${id}`,
                {
                    items,
                }
            );

            Swal.fire({
                icon: "success",
                title: "¡Hecho!",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: data ?? "Operación exitosa",
            }).then(() => {
                window.location.reload();
            });
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: error.response.data ?? "Error al enviar el formulario",
            });
        }
    }

    // close
    $close?.addEventListener("click", async () => {
        const id = $close.getAttribute("data-id");

        const result = await Swal.fire({
            title: "¿Estás seguro de finalizar la evaluación?",
            text: "No podrás deshacer esta acción.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, finalizar",
            cancelButtonText: "Cancelar",
        });

        if (!result.isConfirmed) return;

        try {
            const { data } = await axios.post(`/api/evaluations/close/${id}`);
            Swal.fire({
                icon: "success",
                title: "¡Hecho!",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: data ?? "Operación exitosa",
            }).then(() => {
                window.location.reload();
            });
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: error.response.data ?? "Error al enviar el formulario",
            });
        }
    });
});
