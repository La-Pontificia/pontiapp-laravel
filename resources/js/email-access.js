document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".toggle-access");

    toggles?.forEach((btn) => {
        btn.addEventListener("click", function () {
            const parentDivElement = btn.closest(".access-button");
            const accessList = parentDivElement.nextElementSibling;
            accessList.classList.toggle("hidden");
        });
    });
});
