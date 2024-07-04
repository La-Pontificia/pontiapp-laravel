import "./bootstrap";

window.onPaste = (e) => {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    document.execCommand("insertText", false, text);
};

window.disabledComponents = (components) => {
    components.forEach((c) => {
        c.disabled = true;
        c.classList.add("cursor-not-allowed");
        c.classList.add("animate-pulse");
    });
};

window.enabledComponents = (components) => {
    components.forEach((c) => {
        c.disabled = false;
        c.classList.remove("cursor-not-allowed");
        c.classList.remove("animate-pulse");
    });
};

window.disabledFormChildren = (form) => {
    form.querySelectorAll("input").forEach((c) => {
        c.disabled = true;
        c.classList.add("cursor-not-allowed");
        c.classList.add("animate-pulse");
    });
    form.querySelectorAll("select").forEach((c) => {
        c.disabled = true;
        c.classList.add("cursor-not-allowed");
        c.classList.add("animate-pulse");
    });
    form.querySelectorAll("textarea").forEach((c) => {
        c.disabled = true;
        c.classList.add("cursor-not-allowed");
        c.classList.add("animate-pulse");
    });
    form.querySelectorAll("button").forEach((c) => {
        c.disabled = true;
        c.classList.add("cursor-not-allowed");
        c.classList.add("animate-pulse");
    });
};

window.defaultProfile =
    "https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg";

window.enableFormChildren = (form) => {
    form.querySelectorAll("input").forEach((c) => {
        c.disabled = false;
        c.classList.remove("cursor-not-allowed");
        c.classList.remove("animate-pulse");
    });

    form.querySelectorAll("select").forEach((c) => {
        c.disabled = false;
        c.classList.remove("cursor-not-allowed");
        c.classList.remove("animate-pulse");
    });

    form.querySelectorAll("textarea").forEach((c) => {
        c.disabled = false;
        c.classList.remove("cursor-not-allowed");
        c.classList.remove("animate-pulse");
    });

    form.querySelectorAll("button").forEach((c) => {
        c.disabled = false;
        c.classList.remove("cursor-not-allowed");
        c.classList.remove("animate-pulse");
    });
};

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

window.toast = Swal.mixin({
    toast: true,
    position: "bottom-left",
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
});
