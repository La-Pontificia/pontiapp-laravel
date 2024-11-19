import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const queryInputs = $$(".dinamic-search");
    const dinamicForms = $$(".dinamic-form");
    const $dinamicFormToParams = $$(".dinamic-form-to-params");

    const dinamicAlerts = $$(".dinamic-alert");

    const $refreshPage = $$(".refresh-page");
    const $dinamicRequests = $$(".dinamic-request");
    const $dinamicDownloadFile = $$(".dinamic-download-file");

    $dinamicDownloadFile?.forEach((f) => {
        f.addEventListener("click", async () => {
            const url = f.getAttribute("data-url");
            const name = f.getAttribute("data-name");

            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", name);
            document.body.appendChild(link);
            link.click();
            link.remove();
        });
    });

    $dinamicRequests?.forEach((f) => {
        f.addEventListener("click", async () => {
            f.disabled = true;
            const method = f.getAttribute("data-method") ?? "POST";
            const alert = f.getAttribute("data-alert");
            const description = f.getAttribute("data-description");
            const url = f.getAttribute("data-url");
            const current_url = new URL(window.location.href);
            const searchParams = current_url.searchParams;

            try {
                if (alert) {
                    const result = await Swal.fire({
                        title: alert,
                        text:
                            description ??
                            "¿Estás seguro de realizar esta acción?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sí, confirmar",
                        cancelButtonText: "Cancelar",
                    });

                    if (!result.isConfirmed) {
                        f.disabled = false;
                        return;
                    }
                }

                const { data } = await axios({
                    method,
                    url: `${url}?${searchParams.toString()}`,
                });

                Swal.fire({
                    icon: "info",
                    title: "¡Hecho!",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text: data ?? "Petición exitosa",
                }).then(() => {
                    redirect && (window.location.href = redirect);
                });
            } catch (e) {
                const content =
                    typeof e.response.data === "object"
                        ? e.response.data.message
                        : e.response.data;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text: content ?? "Error al realizar esta Petición",
                });
            } finally {
                f.disabled = false;
            }
        });
    });

    $refreshPage?.forEach((f) => {
        f.addEventListener("click", function () {
            $("#loading").setAttribute("data-open", "");
            window.location.reload();
        });
    });

    const $dinamicToUrl = $$(".dinamic-to-url");
    const $dinamicInputToUrl = $$(".dinamic-input-to-url");
    const $dinamicCheckboxToUrl = $$(".dinamic-checkbox-to-url");

    $dinamicToUrl?.forEach((f) => {
        f.addEventListener("change", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);
            if (value !== "0") params.set(name, value);
            else params.delete(name);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, "", newUrl);
        });
    });

    $dinamicInputToUrl?.forEach((f) => {
        f.addEventListener("input", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);
            if (value !== "") params.set(name, value);
            else params.delete(name);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, "", newUrl);
        });
    });

    $dinamicCheckboxToUrl?.forEach((f) => {
        f.addEventListener("change", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);

            if (name.includes("[]")) {
                const realName = name.replace("[]", "");
                const currentValue = params.get(realName);
                const values = currentValue?.split(",") ?? [];
                const has = values.includes(value);

                const newValue = has
                    ? values.filter((v) => v !== value)
                    : [...values, value];

                if (newValue.length) params.set(realName, newValue.join(","));
                else params.delete(realName);

                const newUrl = `${
                    window.location.pathname
                }?${params.toString()}`;
                window.history.replaceState({}, "", newUrl);
            } else {
                const already = params.get(name);

                if (!already) params.set(name, value);
                else params.delete(name);

                const newUrl = `${
                    window.location.pathname
                }?${params.toString()}`;
                window.history.replaceState({}, "", newUrl);
            }
        });
    });

    // PREVENT DEFAULT PASTE IN ELEMENTS WITH CONTENTEDITABLE
    $$("[contenteditable]").forEach((element) => {
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

    // Dinamic forms
    dinamicForms?.forEach((f) => {
        f.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(f);

            const addParams = f.hasAttribute("data-add-params");

            const redirectToResponse = f.hasAttribute(
                "data-redirect-to-response"
            );
            const windowUrl = new URL(window.location.href);
            const searchParams = windowUrl.searchParams;

            const url = addParams
                ? `${f.action}?${searchParams.toString()}`
                : f.action;
            const method = f.method ?? "POST";
            const redirect = f.getAttribute("data-redirect");

            const formComponents = f.querySelectorAll(
                "input, textarea, select"
            );

            formComponents.forEach((c) => {
                const isStrategyDataset = c.getAttribute("data-strategy");
                if (isStrategyDataset === "dataset") {
                    const value = c.getAttribute("data-value");
                    const name = c.name;
                    formData.set(name, value);
                }
            });

            window.disabledFormChildren(f);

            try {
                const { data } = await axios({
                    method,
                    url: url,
                    data: formData,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                if (redirectToResponse) {
                    window.location.href = data;
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "¡Hecho!",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        text: data ?? "Operación exitosa",
                    }).then(() => {
                        redirect
                            ? (window.location.href = redirect)
                            : window.location.reload();
                    });
                }
            } catch (error) {
                console.log(error);
                const content =
                    typeof error.response.data === "object"
                        ? error.response.data.message
                        : error.response.data;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text: content ?? "Error al enviar el formulario",
                });
            } finally {
                window.enabledFormChildren(f);
            }
        });
    });

    // Dinamic alerts
    dinamicAlerts?.forEach((f) => {
        f.onclick = async () => {
            const param = f.getAttribute("data-param");
            const method = f.getAttribute("data-method") ?? "POST";
            const atitle = f.getAttribute("data-atitle");
            const adescription = f.getAttribute("data-adescription");
            const dataAlertvariant = f.getAttribute("data-alertvariant");
            const result = await Swal.fire({
                title: atitle,
                text: adescription,
                icon: dataAlertvariant ?? "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, confirmar",
                cancelButtonText: "Cancelar",
            });

            if (!result.isConfirmed) return;

            try {
                const { data } = await axios(param, {
                    method: method,
                });
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
                const content =
                    typeof error.response.data === "object"
                        ? error.response.data.message
                        : error.response.data;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text: content ?? "Error al enviar el formulario",
                });
            }
        };
    });

    // DINAMIC FORM TO PARAMS
    $dinamicFormToParams?.forEach((f) => {
        if (f instanceof HTMLFormElement) {
            f.onsubmit = (e) => {
                e.preventDefault();
                const formData = new FormData(f);
                const params = new URLSearchParams(window.location.search);
                params.delete("page");
                formData.forEach((value, key) => {
                    if (key.includes("[]")) {
                        const array = [];
                        formData.getAll(key).forEach((v) => {
                            array.push(v);
                        });
                        formData.delete(key);
                        formData.set(key.replace("[]", ""), array.join(","));
                    } else {
                        formData.set(key, value);
                    }
                });

                console.log(Object.fromEntries(formData));

                // delete all params
                params.forEach((_, key) => {
                    params.delete(key);
                });

                formData.forEach((value, key) => {
                    if (!value) params.delete(key);
                    else params.set(key, value);
                    window.location.search = params.toString();
                });
            };
        }
    });
});
