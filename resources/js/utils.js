const Toast = Swal.mixin({
    toast: true,
    position: "bottom-left",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);

    const queryInputs = document.querySelectorAll(".dinamic-search");
    const dinamicSelects = document.querySelectorAll(".dinamic-select");
    const dinamicForms = document.querySelectorAll(".dinamic-form");

    dinamicSelects?.forEach((f) => {
        f.addEventListener("change", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);
            if (value !== "0") params.set(name, value);
            else params.delete(name);
            window.location.search = params.toString();
        });
    });

    // PREVENT DEFAULT PASTE IN ELEMENTS WITH CONTENTEDITABLE
    document.querySelectorAll("[contenteditable]").forEach((element) => {
        element.addEventListener("paste", (e) => {
            e.preventDefault();
            const text = e.clipboardData.getData("text/plain");
            document.execCommand("insertText", false, text);
        });
    });

    // SEARCH INPUTS
    queryInputs?.forEach((f) => {
        f?.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                const value = e.target.value;
                const params = new URLSearchParams(window.location.search);
                params.set("q", value);
                window.location.search = params.toString();
            }
        });
    });

    const disabledComponents = (components) => {
        components.forEach((c) => {
            c.disabled = true;
            c.classList.add("cursor-not-allowed");
            c.classList.add("animate-pulse");
        });
    };

    const enabledComponents = (components) => {
        components.forEach((c) => {
            c.disabled = false;
            c.classList.remove("cursor-not-allowed");
            c.classList.remove("animate-pulse");
        });
    };

    // FORMS
    dinamicForms?.forEach((f) => {
        f.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(f);
            const url = f.action;
            const method = f.method;
            const formId = f.id;

            const buttonSubmitByFormId = document.querySelector(
                `button[form="${formId}"]`
            );

            disabledComponents(f.querySelectorAll("input"));
            disabledComponents(f.querySelectorAll("select"));
            disabledComponents(f.querySelectorAll("textarea"));
            disabledComponents([buttonSubmitByFormId]);

            try {
                await axios({
                    method: method,
                    url: url,
                    data: formData,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                window.location.reload();
            } catch (error) {
                console.log(error);
                Toast.fire({
                    icon: "error",
                    title:
                        error.response.data ?? "Error al enviar el formulario",
                });
            } finally {
                enabledComponents(f.querySelectorAll("input"));
                enabledComponents(f.querySelectorAll("select"));
                enabledComponents(f.querySelectorAll("textarea"));
                enabledComponents([buttonSubmitByFormId]);
            }
        });
    });
});
