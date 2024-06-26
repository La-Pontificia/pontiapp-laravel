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
            Toast.fire({
                icon: "error",
                title: "An error occurred",
                description: "Please try again",
            });
        }
    });
});
