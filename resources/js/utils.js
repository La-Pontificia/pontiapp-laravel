import Autocomplete from "@trevoreyre/autocomplete-js";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);

    const queryInputs = document.querySelectorAll(".dinamic-search");
    const dinamicSelects = document.querySelectorAll(".dinamic-select");
    const dinamicForms = document.querySelectorAll(".dinamic-form");
    const $autocompletes = document.querySelectorAll(".autocomplete");

    const dinamicAlerts = document.querySelectorAll(".dinamic-alert");

    const dinamicFormAcumulate = document.querySelectorAll(
        ".dinamic-form-acumulate"
    );

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
                    method: method,
                    url: url,
                    data: formData,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
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
            } catch (error) {
                console.log(error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text:
                        error.response.data ?? "Error al enviar el formulario",
                });
            } finally {
                window.enabledFormChildren(f);
            }
        });
    });

    // autocompletes
    $autocompletes?.forEach((f) => {
        const param = f.getAttribute("data-param");
        const atitle = f.getAttribute("data-atitle");
        const avalue = f.getAttribute("data-value");
        const adescription = f.getAttribute("data-adescription");

        const input = f.querySelector("input");
        new Autocomplete(f, {
            search: async (input) => {
                const url = `${param}?query=${encodeURI(input)}`;

                return new Promise((resolve) => {
                    if (input.length < 3) {
                        return resolve([]);
                    }
                    fetch(url)
                        .then((response) => response.json())
                        .then((data) => {
                            const results = data.map((result, index) => {
                                return { ...result, index };
                            });
                            resolve(results);
                        });
                });
            },

            renderResult: (result, props) => {
                return `
                    <li ${props}>
                        <div class="autocomplete-title">
                        ${result[atitle]}
                        </div>
                        <div class="autocomplete-snippet">
                        ${result[adescription]}
                        </div>
                    </li>
                 `;
            },
            getResultValue: (result) => result[atitle],

            onSubmit: (result) => {
                input.setAttribute("data-value", result[avalue]);
            },
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
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text:
                        error.response.data ?? "Error al enviar el formulario",
                });
            }
        };
    });

    // Dinamic form acumulate
    dinamicFormAcumulate?.forEach((form) => {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            const array = [];
            formData.forEach((value, key) => {
                array.push(value);
            });

            const params = new URLSearchParams(window.location.search);
            params.set("terminals", array.join(","));
            window.location.search = params.toString();
        });
    });

    // TOOLTIP

    Array.from(document.querySelectorAll("[tip]")).forEach((el) => {
        let tip = document.createElement("div");
        tip.classList.add("tooltip");
        tip.innerText = el.getAttribute("tip");
        let delay = el.getAttribute("tip-delay");
        if (delay) {
            tip.style.transitionDelay = delay + "s";
        }
        tip.style.transform =
            "translate(" +
            (el.hasAttribute("tip-left") ? "calc(-100% - 5px)" : "15px") +
            ", " +
            (el.hasAttribute("tip-top") ? "-100%" : "0") +
            ")";
        el.appendChild(tip);
        el.onmousemove = (e) => {
            tip.style.left = e.clientX + "px";
            tip.style.top = e.clientY + "px";
        };
    });
});
