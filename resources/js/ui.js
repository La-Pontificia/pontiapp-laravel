document.addEventListener("DOMContentLoaded", function () {
    const $$ = document.querySelectorAll.bind(document);

    // dinamic tabs
    const $parent_tabs = $$(".dinamic-tabs");
    $parent_tabs?.forEach(($parent_tab) => {
        const $tabs = $parent_tab.querySelectorAll("*[data-tab]");

        $tabs.forEach(($tab) => {
            $tab.addEventListener("click", function (e) {
                const data_tab = e.target.getAttribute("data-tab");
                const $content = document.querySelector(
                    "[data-tab-content=" + data_tab + "]"
                );

                if (!$content) return;

                $tabs.forEach(($tab) => {
                    $tab.removeAttribute("data-active");
                });

                $tab.setAttribute("data-active", "true");

                const $contents = document.querySelectorAll(
                    "*[data-tab-content]"
                );

                $contents.forEach(($content) => {
                    $content.setAttribute("data-hidden", "true");
                });

                $content.removeAttribute("data-hidden");
            });
        });
    });

    // sidebar
    const $sidebarButton = $("#sidebar-button");
    const $sidebar = $("#sidebar");
    const $sidebarOverlay = $("#sidebar-overlay");

    $sidebarButton?.addEventListener("click", function () {
        $sidebar.classList.remove("max-lg:-translate-x-full");
        $sidebarOverlay.classList.remove("hidden");
    });

    $sidebarOverlay?.addEventListener("click", function () {
        $sidebar.classList.add("max-lg:-translate-x-full");
        $sidebarOverlay.classList.add("hidden");
    });
});
