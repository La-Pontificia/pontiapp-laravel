import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);
    const sidebarState = localStorage.getItem("sidebar-state");

    const toogleSidebar = $("#toogle-sidebar");
    const sidebar = $("#cta-sidebar");

    toogleSidebar.addEventListener("click", function () {
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
