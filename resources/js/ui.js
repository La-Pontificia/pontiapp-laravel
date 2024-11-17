document.addEventListener("DOMContentLoaded", function () {
    const $$ = document.querySelectorAll.bind(document);
    const $ = document.querySelector.bind(document);

    const $filterButtons = $$(".filter-button");
    const $feedbackLoading = $("#loading-feedback");

    $filterButtons?.forEach(($button) => {
        $button.onclick = () => {
            $feedbackLoading.setAttribute("data-open", "true");
        };
    });

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
        $sidebar.attributes.getNamedItem("data-expanded")
            ? ($sidebar.removeAttribute("data-expanded"),
              $sidebarOverlay.removeAttribute("data-expanded"))
            : ($sidebar.setAttribute("data-expanded", "true"),
              $sidebarOverlay.setAttribute("data-expanded", "true"));
    });

    $sidebarOverlay?.addEventListener("click", function () {
        $sidebar.removeAttribute("data-expanded");
        $sidebarOverlay.removeAttribute("data-expanded");
    });

    const $itemsSidebar = $sidebar.querySelectorAll(".sidebar-item");
    const $itemContents = $sidebar.querySelectorAll(".sidebar-item-content");

    $itemsSidebar?.forEach(($item) => {
        const $button = $item.querySelector(".sidebar-item-button");
        const $content = $item.querySelector(".sidebar-item-content");

        $button.onclick = () => {
            const expanded = $item.getAttribute("data-expanded");
            if (expanded) {
                $item.removeAttribute("data-expanded");
                $content.removeAttribute("data-expanded");
            } else {
                $itemsSidebar.forEach(($item) => {
                    $item.removeAttribute("data-expanded");
                });
                $itemContents.forEach(($content) => {
                    $content.removeAttribute("data-expanded");
                });
                $item.setAttribute("data-expanded", "true");
                $content.setAttribute("data-expanded", "true");
            }
        };
    });

    //dinamic switch preview to form

    const $switchs = $$(".dinamic-switch-form-preview");

    $switchs.forEach(($switch) => {
        $switch.onclick = () => {
            // data-preview='user-details'
            const data = $switch.getAttribute("data-switch");
            const $preview = document.querySelector(
                "[data-preview=" + data + "]"
            );
            const $form = document.querySelector("[data-form=" + data + "]");

            const hasHiddenForm = $form.classList.contains("hidden");

            if (hasHiddenForm) {
                $preview.classList.add("hidden");
                $form.classList.remove("hidden");
            } else {
                $preview.classList.remove("hidden");
                $form.classList.add("hidden");
            }
        };
    });

    // search input

    const $search = $("#search");
    const $searchButton = $("#search-button");
    const $searchInput = $("#search-input");
    const $seachOverlay = $("#search-overlay");
    const $modalSearch = $("#search-result-modal");

    $searchInput?.addEventListener("focus", () => {
        $modalSearch.setAttribute("data-open", "");
        $seachOverlay?.setAttribute("data-open", "");
    });

    if ($searchButton) {
        $searchButton.onclick = () => {
            $search?.setAttribute("data-open", "");
            $seachOverlay?.setAttribute("data-open", "");
            $searchInput?.focus();
        };
    }

    if ($seachOverlay) {
        $seachOverlay.onclick = () => {
            $search.removeAttribute("data-open");
            $seachOverlay.removeAttribute("data-open");
            $modalSearch.removeAttribute("data-open");
        };
    }
});
