document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    const form = $("#user-role-form");

    form?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const { title } = Object.fromEntries(new FormData(e.target));
        const privileges = Array.from(
            form.querySelectorAll('input[name="privileges[]"]:checked')
        ).map((input) => input.value);

        try {
            await axios.post("/api/users/roles", {
                title,
                privileges,
            });
        } catch (error) {
            console.error(error);
            window.toast.fire({
                icon: "error",
                title:
                    error.response.data ??
                    "Ocurrió un error al intentar crear el rol",
            });
        }
    });

    // UI interactions for user roles
    function updatePrivilegeCount(element) {
        const container = element.closest(".border");
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

    function updateParentCheckboxes(checkbox) {
        const subgroup = checkbox.closest(".border");
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
    }

    document.querySelectorAll(".select-all-group").forEach((groupCheckbox) => {
        groupCheckbox.addEventListener("change", function () {
            const checkboxes = this.closest(".border").querySelectorAll(
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
                const checkboxes = this.closest(".border").querySelectorAll(
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
                this.closest(".border").querySelector(".group-content");
            content.style.display =
                content.style.display === "none" ? "grid" : "none";
            const svg = this.querySelector("svg");
            svg.style.transform =
                content.style.display === "none"
                    ? "rotate(0deg)"
                    : "rotate(90deg)";
        });
    });

    document.querySelectorAll(".toggle-subgroup").forEach((toggleButton) => {
        toggleButton.addEventListener("click", function () {
            const content =
                this.closest(".border").querySelector(".subgroup-content");
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
