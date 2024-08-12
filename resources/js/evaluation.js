import axios from "axios";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const $table = $("#evaluations");
    const $selfQualify = $("#evaluation-self-qualify-button");
    const $qualify = $("#evaluation-qualify-button");
    const $close = $("#evaluation-close-button");

    const $totalSelfQualification = $("#total-self-qualification");
    const $totalQualification = $("#total-qualification");
    const $rows = Array.from($table?.querySelectorAll("tr") ?? []);

    function getTotalSelfQualification() {
        const total = $rows.reduce((acc, $row) => {
            const percentage =
                $row
                    .querySelector(".percentage")
                    ?.getAttribute("data-percentage") || 0;

            const selfQualification =
                $row.querySelector(".self-qualification")?.value || 0;

            return acc + (Number(selfQualification) * Number(percentage)) / 100;
        }, 0);
        return total.toFixed(2);
    }

    function getTotalQualification() {
        const total = $rows.reduce((acc, $row) => {
            const percentage =
                $row
                    .querySelector(".percentage")
                    ?.getAttribute("data-percentage") || 0;

            const qualification =
                $row.querySelector(".qualification")?.value || 0;

            return acc + (Number(qualification) * Number(percentage)) / 100;
        }, 0);
        return total.toFixed(2);
    }

    function getItems() {
        const items = $rows.map(($row) => {
            const id = $row.getAttribute("data-id");
            const selfQualification = $row.querySelector(
                ".self-qualification"
            )?.value;
            const qualification = $row.querySelector(".qualification")?.value;
            return {
                id,
                self_qualification: Number(selfQualification),
                qualification: Number(qualification),
            };
        });
        return items;
    }

    $rows?.forEach(($row) => {
        const $selfQualificationSelect = $row.querySelector(
            ".self-qualification"
        );
        const $qualificationSelect = $row.querySelector(".qualification");

        $selfQualificationSelect?.addEventListener("change", async (e) => {
            $totalSelfQualification.innerHTML = getTotalSelfQualification();
        });

        $qualificationSelect?.addEventListener("change", async (e) => {
            $totalQualification.innerHTML = getTotalQualification();
        });
    });

    $selfQualify?.addEventListener("click", () => {
        const id = $selfQualify.getAttribute("data-id");
        void qualify(id, getTotalSelfQualification(), getItems());
    });

    $qualify?.addEventListener("click", () => {
        const id = $qualify.getAttribute("data-id");
        void qualify(id, getTotalQualification(), getItems(), false);
    });

    async function qualify(id, total, items, selfQualify = true) {
        if (total == 0) {
            return window.alert(
                "Oops...",
                `La ${
                    selfQualify ? "autocalificación" : "calificación"
                } total no puede ser 0`
            );
        }

        await window.mutation(
            `/api/evaluations/${
                selfQualify ? "self-qualify" : "qualify"
            }/${id}`,
            { items },
            `¿Estás seguro de finalizar la ${
                selfQualify ? "autocalificación" : "calificación"
            } de los objetivos?`,
            "No podrás deshacer esta acción.",
            null,
            selfQualify ? "autocalificar" : "calificar"
        );
    }

    // close
    $close?.addEventListener("click", async () => {
        const id = $close.getAttribute("data-id");
        await window.mutation(
            `/api/evaluations/close/${id}`,
            {},
            "¿Estás seguro de finalizar la evaluación?",
            "No podrás deshacer esta acción."
        );
    });

    // feedback

    const $feedback = $("#feedback-open");

    $feedback?.addEventListener("click", async () => {
        const id = $feedback.getAttribute("data-id");
        const read = $feedback.hasAttribute("data-read");

        if (read) return;

        await axios.post(`/api/evaluations/${id}/feedback/read`);

        $feedback.addAttribute("data-read", true);
    });
});
