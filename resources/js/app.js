import "./bootstrap.js";
import "./user_roles.js";
import "./schedules.js";
import "./users.js";
import "./slug_user.js";
import "./edas.js";
import "./goals.js";
import "./utils.js";
import "./evaluation.js";
import "./questionnaires-templates.js";
import "./email-access.js";
import "./assists.js";

import Cookie from "js-cookie";

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

window.toast = Swal.mixin({
    toast: true,
    position: "bottom-left",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

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

window.defaultProfile =
    "https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);

    const toogleSidebar = $("#toogle-sidebar");

    toogleSidebar?.addEventListener("click", function () {
        const state =
            Cookie.get("sidebar") !== undefined
                ? Cookie.get("sidebar")
                : "true";

        if (state == "false") {
            Cookie.set("sidebar", "true", { expires: 365 });
        } else {
            Cookie.set("sidebar", "false", { expires: 365 });
        }
    });
});
