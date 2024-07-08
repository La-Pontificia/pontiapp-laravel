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

            window.disabledFormChildren(f);
            window.disabledComponents([buttonSubmitByFormId]);

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
                window.toast.fire({
                    icon: "error",
                    title:
                        error.response.data ?? "Error al enviar el formulario",
                });
            } finally {
                window.enableFormChildren(f);
                window.enabledComponents([buttonSubmitByFormId]);
            }
        });
    });
});
