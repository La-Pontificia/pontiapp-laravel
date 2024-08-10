import moment from "moment";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    let goals = [];
    let goals_to_delete = [];

    const $sentGoalsButton = $("#sent-goals-button");
    const $input_id = $("#input_id");

    const $goalSheet = $("#goal-sheet");
    const $tableContent = $("#table-content");
    const $totalPercentage = $("#total-percentage");
    const $initGoalSheet = $("#init-goal-sheet");
    const $goalTemplate = $("#goal-template")?.content;
    const $goals = $("#goals");
    const $goalSheetclose = $goalSheet?.querySelector("#goal-sheet-close");
    const $goalSheetsubmit = $goalSheet?.querySelector("#goal-sheet-submit");
    const $goalSheetremove = $goalSheet?.querySelector("#goal-sheet-remove");
    const $openGoalButtons = document.querySelectorAll(".open-goal-button");

    const $title = $goalSheet?.querySelector("#goal-title");
    const $description = $goalSheet?.querySelector("#goal-description");
    const $indicators = $goalSheet?.querySelector("#goal-indicators");
    const $percentage = $goalSheet?.querySelector("#goal-percentage");
    const $comments = $goalSheet?.querySelector("#goal-comments");
    const $info = $goalSheet?.querySelector("#goal-info");
    // GET goals

    // UI functions
    function clearGoalSheet() {
        $goalSheet.removeAttribute("data-id");
        $title.value = "";
        $description.value = "";
        $indicators.value = "";
        $percentage.value = "";
        if ($comments) $comments.value = "";
    }

    function removeAllGoalsDataState() {
        $goals.querySelectorAll(".goal").forEach((goal) => {
            goal.removeAttribute("data-state");
        });
    }

    function addGoalDataState($goal) {
        $goals.querySelectorAll(".goal").forEach((goal) => {
            goal.removeAttribute("data-state");
        });
        $goal.setAttribute("data-state", "open");
    }

    function openNewGoalSheet() {
        clearGoalSheet();
        removeAllGoalsDataState();
        openGoalSheet();
    }

    function openGoalSheet() {
        $goalSheet.setAttribute("data-state", "open");
        $title.focus();
    }

    function closeGoalSheet() {
        $goalSheet.setAttribute("data-state", "close");
        removeAllGoalsDataState();
        clearGoalSheet();
    }

    function getTotalPercentage() {
        return goals.reduce((acc, goal) => acc + parseInt(goal.percentage), 0);
    }

    function renderGoals() {
        $goals.innerHTML = "";
        $totalPercentage.textContent = `${getTotalPercentage()}%`;
        if (getTotalPercentage() > 100) {
            $totalPercentage.classList.add("text-red-500");
        } else {
            $totalPercentage.classList.remove("text-red-500");
        }

        if (goals.length > 0) {
            $initGoalSheet.setAttribute("data-hidden", "true");
            $tableContent.setAttribute("data-open", "true");
        } else {
            $initGoalSheet.removeAttribute("data-hidden");
            $tableContent.removeAttribute("data-open");
        }

        goals.forEach((goal) => {
            const clone = document.importNode($goalTemplate, true);
            const $goal = clone.querySelector(".goal");
            const $goalIndex = clone.querySelector(".goal-index");
            const $goalTitle = clone.querySelector(".goal-title");
            const $goalDescription = clone.querySelector(".goal-description");
            const $goalIndicators = clone.querySelector(".goal-indicators");
            const $goalPercentage = clone.querySelector(".goal-percentage");
            const $goalTimeLine = clone.querySelector(".goal-time-line");
            const $goalFeedback = clone.querySelector(".goal-feedback");

            $goal.setAttribute("data-id", goal._id);

            $goalIndex.textContent = goals.indexOf(goal) + 1;
            $goalTitle.textContent = goal.title;
            $goalDescription.textContent = goal.description;
            $goalIndicators.textContent = goal.indicators;
            $goalPercentage.textContent = `${goal.percentage}%`;

            const goalTimeLine = `${
                goal.created_by ? `Creado por: ${goal.created_by}` : ""
            }
            ${goal.updated_by ? `, Actualizado por: ${goal.updated_by}` : ""}
            `;

            $goalTimeLine.innerHTML = goalTimeLine;
            $goalFeedback.textContent = goal.comments;

            $goals.prepend(clone);

            const hasEdit = $goalSheet.hasAttribute("data-edit");

            // add event listener
            $goal.addEventListener("click", () => {
                addGoalDataState($goal);
                if (hasEdit) {
                    $goalSheetsubmit.innerHTML = "Actualizar";
                    $goalSheetremove.innerHTML = "Eliminar";
                    $goalSheet.setAttribute("data-id", goal._id);
                    $title.value = goal.title;
                    $description.value = goal.description;
                    $indicators.value = goal.indicators;
                    $percentage.value = goal.percentage;

                    $comments.hasAttribute("data-label")
                        ? ($comments.textContent = goal.comments)
                        : ($comments.value = goal.comments);
                } else {
                    $goalSheetsubmit.remove();
                    $goalSheetremove.remove();
                    $title.textContent = goal.title;
                    $description.textContent = goal.description;
                    $indicators.textContent = goal.indicators;
                    $percentage.textContent = `${goal.percentage}%`;
                    $comments.textContent = goal.comments;
                }
                const createdBy = goal.created_by
                    ? `Creado por: ${goal.created_by} el ${moment(
                          goal.created_at
                      ).format("DD/MM/YYYY")}`
                    : "";
                const updatedBy = goal.updated_by
                    ? `<br/> Actualizado por: ${goal.updated_by} el ${moment(
                          goal.updated_at
                      ).format("DD/MM/YYYY")}`
                    : "";
                $info.innerHTML = `${createdBy} ${updatedBy}`;
                openGoalSheet();
            });
        });
    }

    function addNewGoal(goal) {
        goals.push(goal);
        renderGoals();
        clearGoalSheet();
        closeGoalSheet();
    }

    function removeGoal(_id) {
        const goal = goals.find((g) => g._id.toString() === _id.toString());
        if (goal.id) {
            goals_to_delete.push(_id);
        }
        goals = goals.filter((g) => g._id.toString() !== _id.toString());
        renderGoals();
        clearGoalSheet();
        closeGoalSheet();
    }

    function updateGoal(goal, _id) {
        goals = goals.map((g) => {
            if (g._id.toString() === _id.toString()) {
                return { _id, ...g, ...goal };
            }
            return g;
        });

        renderGoals();
        clearGoalSheet();
        closeGoalSheet();
    }

    $goalSheetclose?.addEventListener("click", closeGoalSheet);
    $openGoalButtons.forEach((button) => {
        button.addEventListener("click", () => {
            openNewGoalSheet();
            $goalSheetsubmit.innerHTML = "Agregar";
            $goalSheetremove.innerHTML = "Cancelar";
        });
    });

    $goalSheetsubmit?.addEventListener("click", () => {
        const _id = $goalSheet.getAttribute("data-id");
        if (
            !$title.value ||
            !$description.value ||
            !$indicators.value ||
            !$percentage.value
        ) {
            return window.alert(
                "Hey..!",
                "Por favor, complete todos los campos"
            );
        }

        if (Number($percentage.value) < 1 || Number($percentage.value) > 100) {
            return window.alert(
                "Hey..!",
                "El porcentaje debe estar entre 1 y 100"
            );
        }
        if (_id) {
            updateGoal(
                {
                    title: $title.value,
                    description: $description.value,
                    indicators: $indicators.value,
                    percentage: $percentage.value,
                    comments: $comments && $comments.value,
                },
                _id
            );
        } else {
            addNewGoal({
                _id: window.crypto.randomUUID(),
                id: null,
                title: $title.value,
                description: $description.value,
                indicators: $indicators.value,
                percentage: $percentage.value,
                comments: $comments && $comments.value,
            });
        }
    });

    $goalSheetremove?.addEventListener("click", () => {
        const _id = $goalSheet.getAttribute("data-id");
        if (_id) {
            removeGoal(_id);
        } else {
            closeGoalSheet();
        }
    });

    // send goals to server
    $sentGoalsButton?.addEventListener("click", async () => {
        const total = getTotalPercentage();
        if (total !== 100) {
            return window.alert(
                "Hey..!",
                "La suma de los porcentajes debe ser 100%"
            );
        }

        const id_eda = $sentGoalsButton.getAttribute("data-id-eda");

        await window.mutation(
            $input_id
                ? `/api/goals/update/${id_eda}`
                : `/api/goals/sent/${id_eda}`,
            {
                goals,
                goals_to_delete,
            },
            "Enviar objetivos",
            `¿Estás seguro de enviar los objetivos?${
                goals_to_delete.length > 0
                    ? ". Se eliminarán los objetivos seleccionados y sus evaluaciones relacionadas"
                    : ""
            }`
        );
    });

    if ($input_id) {
        if ($sentGoalsButton)
            $sentGoalsButton.textContent = "Reenviar objetivos";
        const data = await window.query(`/api/goals/by-eda/${$input_id.value}`);
        data.map((goal) => {
            goals.push({
                _id: goal.id,
                id: goal.id,
                title: goal.title,
                description: goal.description,
                indicators: goal.indicators,
                percentage: goal.percentage,
                comments: goal.comments,
                created_at: goal.created_at,
                created_by: goal.createdBy,
                updated_at: goal.updated_at,
                updated_by: goal.updatedBy,
            });
        });
        renderGoals();
    }
});
