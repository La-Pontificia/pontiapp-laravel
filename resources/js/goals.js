document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    let goals = [];
    let goals_to_delete = [];

    // hassles

    const hasEdit = $("#has-edit-goals");
    const hasDelete = $("#has-delete-goals");

    const approveButton = $("#approve-goals-button");

    const AddButton = $("#add-goal-button");
    const inputHiddenId = $("#input-hidden-id-eda");
    const SpanTotalPercentage = $("#total-percentage");
    const PresentationNotGoals = $("#presentation-not-goals");
    const PanelGoals = $("#panel-goals");
    const AddButton2 = $("#add-goal-button-2");
    const tableGoals = $("#table-goals");
    const submitGoalsButton = $("#submit-goals-button");
    const percentages = Array.from({ length: 100 }, (_, i) => i + 1);

    const getTotalPercentage = () =>
        goals.reduce((acc, goal) => acc + parseInt(goal.percentage), 0);

    // fetch goals if inputHiddenId exists
    if (inputHiddenId) {
        AddButton.disabled = true;
        const res = await axios.get(`/api/goals/by-eda/${inputHiddenId.value}`);
        res.data.map((goal) => {
            goals.push({
                id: goal.id,
                goal: goal.goal,
                description: goal.description,
                is_new: false,
                indicators: goal.indicators,
                percentage: goal.percentage,
                created_at: goal.created_at,
                created_by: goal.created_by,
                updated_by: goal.updated_by,
                updated_at: goal.updated_at,
            });
        });
    }

    const verifyGoals = () => {
        if (!PresentationNotGoals) return;
        if (!PanelGoals) return;
        if (!submitGoalsButton) return;
        if (!AddButton) return;

        if (goals.length > 0) {
            PresentationNotGoals.classList.add("hidden");
            PanelGoals.classList.remove("hidden");
        } else {
            PresentationNotGoals.classList.remove("hidden");
            PanelGoals.classList.add("hidden");
        }

        const totalPercentage = getTotalPercentage();

        SpanTotalPercentage.innerHTML = totalPercentage;
        if (totalPercentage === 100) {
            submitGoalsButton.disabled = false;
            AddButton.disabled = true;
        } else if (totalPercentage > 100) {
            submitGoalsButton.disabled = true;
            AddButton.disabled = true;
        } else {
            AddButton.disabled = false;
            submitGoalsButton.disabled = true;
        }
    };

    const onPaste = (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData("text/plain");
        document.execCommand("insertText", false, text);
    };

    const renderGoals = () => {
        if (!tableGoals) return;

        tableGoals.innerHTML = "";
        goals.forEach((goal, index) => {
            // Row
            const row = document.createElement("tr");
            row.className =
                "[&>td]:align-top [&>td>div]:p-2 [&>td>div]:min-h-20 [&>td>div]:bg-transparent [&>td>div]:rounded-md";

            // Goal
            const divGoal = document.createElement("div");
            divGoal.contentEditable = !!hasEdit;
            divGoal.className = "w-full text-indigo-600 font-semibold";
            divGoal.ariaPlaceholder = "Ingrese el nombre del objetivo";
            divGoal.innerHTML = goal.goal;
            divGoal.oninput = (e) => {
                goals[index].goal = e.target.innerHTML;
                verifyGoals();
            };
            divGoal.onpaste = onPaste;

            // Description
            const divDescription = document.createElement("div");
            divDescription.contentEditable = !!hasEdit;
            divDescription.className = "w-full";
            divDescription.ariaPlaceholder = "Ingrese la descripcion";
            divDescription.innerHTML = goal.description;
            divDescription.oninput = (e) => {
                goals[index].description = e.target.innerHTML;
                verifyGoals();
            };
            divDescription.onpaste = onPaste;

            // Indicators
            const divIndicators = document.createElement("div");
            divIndicators.contentEditable = !!hasEdit;
            divIndicators.className = "w-full";
            divIndicators.ariaPlaceholder = "Ingrese los indicadores";
            divIndicators.innerHTML = goal.indicators;
            divIndicators.oninput = (e) => {
                goals[index].indicators = e.target.innerHTML;
                verifyGoals();
            };
            divIndicators.onpaste = onPaste;

            // Select Percentage
            const sPercentage = document.createElement("select");
            sPercentage.className = "border-0 bg-transparent cursor-pointer";
            sPercentage.disabled = !hasEdit;
            percentages.forEach((percentage) => {
                const option = document.createElement("option");
                option.selected =
                    goal.percentage.toString() === percentage.toString();
                option.value = percentage;
                option.textContent = `${percentage}%`;
                sPercentage.appendChild(option);
            });
            sPercentage.onchange = (e) => {
                goals[index].percentage = e.target.value;
                verifyGoals();
            };

            // Created By
            const cCreatedBy = document.createElement("td");
            if (goal.created_by) {
                const createdByImg = document.createElement("img");
                createdByImg.src = goal.created_by?.profile;
                createdByImg.className = "w-full h-full object-cover";
                const createdFigureDivImg = document.createElement("figure");
                createdFigureDivImg.className =
                    "w-8 rounded-full aspect-square overflow-hidden";
                createdFigureDivImg.title = `Agregado el ${new Date(
                    goal.created_at
                ).toLocaleString()} por ${goal.created_by?.full_name}`;
                createdFigureDivImg.appendChild(createdByImg);
                cCreatedBy.className = "font-semibold p-2";
                cCreatedBy.appendChild(createdFigureDivImg);
            }

            // updated By
            const cUpdatedBy = document.createElement("td");
            if (goal.updated_by) {
                const updatedByImg = document.createElement("img");
                updatedByImg.src = goal.updated_by?.profile;
                updatedByImg.className = "w-full h-full object-cover";
                const updatedByFigureDivImg = document.createElement("figure");
                updatedByFigureDivImg.className =
                    "w-8 rounded-full aspect-square overflow-hidden";
                updatedByFigureDivImg.title = `Actualizado el ${new Date(
                    goal.updated_at
                ).toLocaleString()} por ${goal.updated_by?.full_name}`;
                updatedByFigureDivImg.appendChild(updatedByImg);
                cUpdatedBy.className = "font-semibold p-2";
                cUpdatedBy.appendChild(updatedByFigureDivImg);
            }

            // Delete Button
            const deleteButton = document.createElement("button");
            deleteButton.innerHTML = "Eliminar";
            deleteButton.disabled = !hasDelete;
            deleteButton.className =
                "bg-neutral-200 px-2 m-2 rounded-md p-1 font-semibold";
            deleteButton.onclick = () => {
                goals = goals.filter((g) => g.id !== goal.id);
                if (!goal.is_new) {
                    goals_to_delete.push(goal.id);
                }
                renderGoals();
            };

            // C Index
            const cIndex = document.createElement("td");
            cIndex.className = "font-semibold p-2";
            cIndex.innerHTML = `${index + 1}`;

            const cGoal = document.createElement("td");
            cGoal.appendChild(divGoal);

            const cDescription = document.createElement("td");
            cDescription.appendChild(divDescription);

            const cIndicators = document.createElement("td");
            cIndicators.appendChild(divIndicators);

            const cPercentage = document.createElement("td");
            cPercentage.appendChild(sPercentage);

            const cButton = document.createElement("td");
            cButton.appendChild(deleteButton);

            row.appendChild(cIndex);
            row.appendChild(cGoal);
            row.appendChild(cDescription);
            row.appendChild(cIndicators);
            row.appendChild(cPercentage);
            if (goal.created_by) row.appendChild(cCreatedBy);
            else if (inputHiddenId)
                row.appendChild(document.createElement("td"));
            if (goal.updated_by) row.appendChild(cUpdatedBy);
            else if (inputHiddenId)
                row.appendChild(document.createElement("td"));
            row.appendChild(cButton);

            tableGoals.appendChild(row);
        });
        verifyGoals();
    };

    const addGoal = () => {
        goals.push({
            id: goals.length + 1,
            goal: "",
            description: "",
            indicators: "",
            percentage: 10,
            is_new: true,
        });
        renderGoals();
    };

    AddButton2?.addEventListener("click", () => {
        addGoal();
    });

    AddButton?.addEventListener("click", () => {
        addGoal();
    });

    // on submit
    submitGoalsButton?.addEventListener("click", async () => {
        const isInvalid =
            goals.some(
                (goal) =>
                    goal.goal === "" ||
                    goal.description === "" ||
                    goal.indicators === ""
            ) || getTotalPercentage() !== 100;
        if (isInvalid) {
            return Swal.fire({
                icon: "warning",
                title: "Hey...",
                text: "Por favor, complete todos los campos y asegurese de que la suma de los porcentajes sea 100%",
            });
        }

        const id_eda = submitGoalsButton.getAttribute("data-id-eda");

        submitGoalsButton.disabled = true;

        const fetchURI = inputHiddenId
            ? `/api/goals/update/${inputHiddenId.value}`
            : "/api/goals/sent";

        try {
            await axios.post(fetchURI, {
                goals_to_create: goals.filter((goal) => goal.is_new),
                goals_to_update: goals.filter((goal) => !goal.is_new),
                id_eda,
                goals_to_delete,
            });
            Swal.fire({
                icon: "success",
                title: "Objetivos enviados",
                text: "Los objetivos fueron enviados correctamente",
            }).then(() => {
                window.location.reload();
            });
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Ocurrio un error al enviar los objetivos, intentelo de nuevo",
            });
        }
    });
    renderGoals();
    if (inputHiddenId) {
        submitGoalsButton.disabled = true;
    }
    // approve goals

    if (approveButton) {
        approveButton.addEventListener("click", async () => {
            const id_eda = approveButton.getAttribute("data-id-eda");
            Swal.fire({
                title: "¿Estás seguro de aprobar los objetivos?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, aprobar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await axios.post("/api/goals/approve", {
                        id_eda,
                    });
                    if (res.status === 200) {
                        Swal.fire({
                            icon: "success",
                            title: "Objetivos aprobados",
                            text: "Los objetivos fueron aprobados correctamente",
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Ocurrio un error al aprobar los objetivos, intentelo de nuevo",
                        });
                    }
                }
            });
        });
    }
});
