import "./bootstrap.js";
import "./user_roles.js";
import "./schedules.js";
import "./users.js";
import "./slug_user.js";
import "./edas.js";
import "./goals.js";
import "./utils.js";
import "./evaluation.js";
import "./questionnaire-templates.js";
import "./email-access.js";
import "./assists.js";
import "./ui.js";
import "./questionnaires.js";
import "./fluentui.js";

// import {
//     fluentSwitch,
//     provideFluentDesignSystem,
// } from "https://unpkg.com/@fluentui/web-components@2.0.0";

// provideFluentDesignSystem().register(fluentSwitch());
// videFluentDesignSystem().register(fluentButton(), fluentDialog());

import axios from "axios";
window.onPaste = (e) => {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    document.execCommand("insertText", false, text);
};

window.disabledComponents = (components) => {
    components.forEach((c) => {
        if (c) {
            c.disabled = true;
            c.classList.add("cursor-not-allowed");
            c.classList.add("animate-pulse");
        }
    });
};

window.enabledComponents = (components) => {
    components.forEach((c) => {
        if (c) {
            c.disabled = false;
            c.classList.remove("cursor-not-allowed");
            c.classList.remove("animate-pulse");
        }
    });
};

window.disabledFormChildren = (form) => {
    const id = form.id;
    const button = document.querySelector(`button[form="${id}"]`);
    if (button) {
        button.disabled = true;
    }
    const elements = form.querySelectorAll("input, select, textarea, button");
    elements.forEach((c) => {
        if (c) {
            c.disabled = true;
            c.classList.add("cursor-not-allowed");
            c.classList.add("animate-pulse");
        }
    });
};

window.enabledFormChildren = (form) => {
    const id = form.id;
    const button = document.querySelector(`button[form="${id}"]`);
    if (button) button.disabled = false;

    const elements = form.querySelectorAll("input, select, textarea, button");
    elements.forEach((c) => {
        if (c) {
            c.disabled = false;
            c.classList.remove("cursor-not-allowed");
            c.classList.remove("animate-pulse");
        }
    });
};

window.debounce = (func, delay) => {
    let timeoutId;
    return function (...args) {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
};

window.query = async (url) => {
    const $$ = document.querySelector.bind(document);
    const $loader = $$("#loader");
    try {
        const { data: resData } = await axios.get(url);
        return resData;
    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: "error",
            title: "Oops...",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            text: error.response.data ?? "Algo salió mal.",
        });
        return null;
    } finally {
        if ($loader) {
            $loader.classList.add("hidden");
        }
    }
};

window.alert = (title = "Confirmar", text = "Confirmar", icon = "warning") =>
    Swal.fire({
        icon,
        title,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        text,
    });

window.mutation = async (
    url,
    data,
    title = "Confirmar operación",
    text = "¿Estás seguro de realizar esta operación?",
    redirect = null,
    confirmButtonText = "Sí, confirmar"
) => {
    try {
        const result = await Swal.fire({
            title,
            text,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText,
            cancelButtonText: "Cancelar",
        });

        if (!result.isConfirmed) return;

        const { data: json } = await axios.post(url, data);
        Swal.fire({
            icon: "success",
            title: "¡Hecho!",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            text: json ?? "Operación exitosa",
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
            text: error.response.data ?? "Error al realizar la operación",
        });
    }
};

window.defaultProfile =
    "https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg";
