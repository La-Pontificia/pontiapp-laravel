import axios from "axios";

const Toast = Swal.mixin({
    toast: true,
    position: "bottom-left",
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
});

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);
    const CreateButton = $("#create-eda");
    const CloseButton = $("#close-eda");
    CreateButton?.addEventListener("click", async () => {
        // disable the button
        CreateButton.disabled = true;
        const id_user = CreateButton.getAttribute("data-id-user");
        const id_year = CreateButton.getAttribute("data-id-year");

        try {
            await axios.post("/api/edas", {
                id_user,
                id_year,
            });

            // reload the page
            location.reload();
        } catch (error) {
            window.toast.fire({
                icon: "error",
                title:
                    error.response.data ??
                    "Ocurrió un error al intentar crear el EDA",
            });
        }
    });

    CloseButton?.addEventListener("click", () => {
        CloseButton.disabled = true;

        const id_eda = CloseButton.getAttribute("data-id");

        Swal.fire({
            title: "¿Estas seguro de cerrar el EDA?",
            text: "No podras deshacer esta acción",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: `Sí, cerrar`,
            cancelButtonText: "Cancelar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    await axios.post(`/api/edas/close/${id_eda}`);
                    // reload the page
                    location.reload();
                } catch (error) {
                    window.toast.fire({
                        icon: "error",
                        title:
                            error.response.data ??
                            "Ocurrió un error al intentar cerrar el EDA",
                    });
                }
            }
        });
    });
});
