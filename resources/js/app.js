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

window.defaultProfile =
    "https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);
    const sidebarState = localStorage.getItem("sidebar-state");

    const toogleSidebar = $("#toogle-sidebar");
    const sidebar = $("#cta-sidebar");

    toogleSidebar?.addEventListener("click", function () {
        const isClose = sidebar.classList.contains("-translate-x-full");

        if (isClose) {
            sidebar.classList.remove("-translate-x-full");
            sidebar.classList.remove("max-sm:-translate-x-full");
            sidebar.classList.remove("fixed");
        } else {
            sidebar.classList.add("-translate-x-full");
            sidebar.classList.add("fixed");
        }
        localStorage.setItem(
            "sidebar-state",
            sidebarState === "open" ? "close" : "open"
        );
    });
});
