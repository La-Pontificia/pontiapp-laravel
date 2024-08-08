document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    // UI interactions for user roles
    function updatePrivilegeCount(element) {
        const container = element.closest(".content");
        const checkboxes = container.querySelectorAll(".privilege-checkbox");
        const countSpan = container.querySelector(".privilege-count");

        const totalCount = checkboxes.length;
        const checkedCount = Array.from(checkboxes).filter(
            (cb) => cb.checked
        ).length;

        countSpan.textContent = `(${checkedCount}/${totalCount})`;
    }

    function updateAllCounts() {
        document
            .querySelectorAll(".select-all-group, .select-all-subgroup")
            .forEach(updatePrivilegeCount);
    }

    // function updateParentCheckboxes(checkbox) {
    //     const subgroup = checkbox.closest(".content");
    //     const subgroupCheckbox = subgroup.querySelector(".select-all-subgroup");
    //     const subgroupCheckboxes = subgroup.querySelectorAll(
    //         ".privilege-checkbox"
    //     );

    //     subgroupCheckbox.checked = Array.from(subgroupCheckboxes).every(
    //         (cb) => cb.checked
    //     );
    //     subgroupCheckbox.indeterminate =
    //         !subgroupCheckbox.checked &&
    //         Array.from(subgroupCheckboxes).some((cb) => cb.checked);

    //     updatePrivilegeCount(subgroupCheckbox);
    // }

    function updateParentCheckboxes(checkbox) {
        const subgroup = checkbox.closest(".content");
        const subgroupCheckbox = subgroup.querySelector(".select-all-subgroup");
        const subgroupCheckboxes = subgroup.querySelectorAll(
            ".privilege-checkbox"
        );

        subgroupCheckbox.checked = Array.from(subgroupCheckboxes).every(
            (cb) => cb.checked
        );
        subgroupCheckbox.indeterminate =
            !subgroupCheckbox.checked &&
            Array.from(subgroupCheckboxes).some((cb) => cb.checked);

        updatePrivilegeCount(subgroupCheckbox);

        // Update the main group checkbox
        const group = subgroup.closest(".group-content");
        if (group) {
            const groupCheckbox = group
                .closest(".content")
                .querySelector(".select-all-group");
            const allSubgroupCheckboxes = group.querySelectorAll(
                ".select-all-subgroup"
            );

            groupCheckbox.checked = Array.from(allSubgroupCheckboxes).every(
                (cb) => cb.checked
            );
            groupCheckbox.indeterminate =
                !groupCheckbox.checked &&
                Array.from(allSubgroupCheckboxes).some(
                    (cb) => cb.checked || cb.indeterminate
                );

            updatePrivilegeCount(groupCheckbox);
        }
    }

    document.querySelectorAll(".select-all-group").forEach((groupCheckbox) => {
        groupCheckbox.addEventListener("change", function () {
            const checkboxes = this.closest(".content").querySelectorAll(
                'input[type="checkbox"]'
            );
            checkboxes.forEach((checkbox) => (checkbox.checked = this.checked));
            updateAllCounts();
        });
    });

    document
        .querySelectorAll(".select-all-subgroup")
        .forEach((subgroupCheckbox) => {
            subgroupCheckbox.addEventListener("change", function () {
                const checkboxes = this.closest(".content").querySelectorAll(
                    ".privilege-checkbox"
                );
                checkboxes.forEach(
                    (checkbox) => (checkbox.checked = this.checked)
                );
                updateParentCheckboxes(this);
                updateAllCounts();
            });
        });

    document
        .querySelectorAll(".privilege-checkbox")
        .forEach((privilegeCheckbox) => {
            privilegeCheckbox.addEventListener("change", function () {
                updateParentCheckboxes(this);
                updateAllCounts();
            });
        });

    document.querySelectorAll(".toggle-group").forEach((toggleButton) => {
        toggleButton.addEventListener("click", function () {
            const content =
                this.closest(".content").querySelector(".group-content");

            content.style.display =
                content.style.display == "none" ? "grid" : "none";

            const svg = this.querySelector("svg");
            svg.style.transform =
                content.style.display == "none"
                    ? "rotate(0deg)"
                    : "rotate(90deg)";
        });
    });

    document.querySelectorAll(".toggle-subgroup").forEach((toggleButton) => {
        toggleButton.addEventListener("click", function () {
            const content =
                this.closest(".content").querySelector(".subgroup-content");
            content.style.display =
                content.style.display === "none" ? "grid" : "none";
            const svg = this.querySelector("svg");
            svg.style.transform =
                content.style.display === "none"
                    ? "rotate(0deg)"
                    : "rotate(90deg)";
        });
    });

    updateAllCounts();

    document
        .querySelectorAll(".privilege-checkbox")
        .forEach((privilegeCheckbox) => {
            updateParentCheckboxes(privilegeCheckbox);
        });
});
