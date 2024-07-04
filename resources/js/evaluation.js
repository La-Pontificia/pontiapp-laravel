document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    let goalsEvaluations = [];
    const inputHiddenIdEvaluation = $("#input-hidden-id-evaluation");
    const tableGoals = $("#table-goals");
    const notes = Array.from({ length: 5 }, (_, i) => i + 1);

    const SpanTotalAverage = $("#total-average");
    const SpanTotalSelfQualification = $("#total-self-qualification");

    const selfQualifacationButton = $("#self-qualification-button");
    const averageButton = $("#average-button");
    const closeButton = $("#close-button");

    const hasAverage = !!$("#has-average");
    const hasSelfQualification = !!$("#has-self-quaification");

    const getTotalAverage = () =>
        goalsEvaluations.reduce(
            (acc, item) =>
                acc +
                (parseInt(item.goal.average ?? "0") * item.goal.percentage) /
                    100,
            0
        );

    const getTotalSelfQualification = () =>
        goalsEvaluations.reduce(
            (acc, item) =>
                acc +
                (parseInt(item.goal.self_qualification ?? "0") *
                    item.goal.percentage) /
                    100,
            0
        );

    if (inputHiddenIdEvaluation) {
        const res = await axios.get(
            `/api/goals/by-evaluation/${inputHiddenIdEvaluation.value}`
        );
        goalsEvaluations = res.data.map((i) => ({
            ...i,
            goal: {
                ...i.goal,
                self_qualification: i.self_qualification ?? 1,
                average: i.average ?? 1,
            },
        }));
    }

    const verifyGoals = () => {
        if (!SpanTotalAverage) return;
        SpanTotalAverage.innerHTML = getTotalAverage().toFixed(2);
        SpanTotalSelfQualification.innerHTML =
            getTotalSelfQualification().toFixed(2);
    };

    const renderGoals = () => {
        if (!tableGoals) return;

        tableGoals.innerHTML = "";
        goalsEvaluations.forEach((item, index) => {
            // Row
            const row = document.createElement("tr");
            row.className =
                "[&>td]:align-top [&>td>div]:p-2 [&>td>div]:min-h-20 [&>td>div]:overflow-y-auto [&>td>div]:max-h-[100px] [&>td>div]:bg-transparent [&>td>div]:rounded-md";

            // Goal
            const divGoal = document.createElement("div");
            divGoal.className = "w-full text-blue-600 font-semibold";
            divGoal.innerHTML = item.goal.goal;

            // Description
            const divDescription = document.createElement("div");
            divDescription.className = "w-full";
            divDescription.innerHTML = item.goal.description;

            // Indicators
            const divIndicators = document.createElement("div");
            divIndicators.className = "w-full";
            divIndicators.ariaPlaceholder = "Ingrese los indicadores";
            divIndicators.innerHTML = item.goal.indicators;

            // Percentage
            const divPercentage = document.createElement("div");
            divPercentage.className =
                "border-0 bg-transparent font-semibold px-4 text-center";
            divPercentage.innerHTML = `${item.goal.percentage}%`;

            // Select N. A.
            const sNA = document.createElement("select");
            sNA.className =
                "border-0 bg-transparent disabled:grayscale disabled:font-normal cursor-pointer text-violet-500 font-bold";
            sNA.disabled = !hasSelfQualification;
            notes.forEach((note) => {
                const option = document.createElement("option");
                option.selected =
                    item.goal.self_qualification?.toString() ===
                    note.toString();
                option.value = note;
                option.textContent = `${note}.0`;
                sNA.appendChild(option);
            });
            sNA.onchange = (e) => {
                goalsEvaluations[index].goal.self_qualification =
                    e.target.value;
                verifyGoals();
            };

            // Select average.
            const sAverage = document.createElement("select");
            sAverage.disabled = !hasAverage;
            sAverage.className =
                "border-0 bg-transparent disabled:grayscale disabled:font-normal cursor-pointer text-green-500 font-bold";
            notes.forEach((note) => {
                const option = document.createElement("option");
                option.selected =
                    item.goal.average?.toString() === note.toString();
                option.value = note;
                option.textContent = `${note}.0`;
                sAverage.appendChild(option);
            });
            sAverage.onchange = (e) => {
                goalsEvaluations[index].goal.average = e.target.value;
                verifyGoals();
            };

            // C Index
            const cIndex = document.createElement("td");
            cIndex.className = "font-semibold text-center p-2";
            cIndex.innerHTML = `${index + 1}`;

            const cGoal = document.createElement("td");
            cGoal.appendChild(divGoal);

            const cDescription = document.createElement("td");
            cDescription.appendChild(divDescription);

            const cIndicators = document.createElement("td");
            cIndicators.appendChild(divIndicators);

            const cPercentage = document.createElement("td");
            cPercentage.appendChild(divPercentage);

            const cSelfQualification = document.createElement("td");
            cSelfQualification.appendChild(sNA);

            const cAverage = document.createElement("td");
            cAverage.appendChild(sAverage);

            // const cButton = document.createElement("td");
            // cButton.appendChild(deleteButton);

            row.appendChild(cIndex);
            row.appendChild(cGoal);
            row.appendChild(cDescription);
            row.appendChild(cIndicators);
            row.appendChild(cPercentage);
            row.appendChild(cSelfQualification);
            row.appendChild(cAverage);
            // if (goal.created_by) row.appendChild(cCreatedBy);
            // else if (inputHiddenId)
            //     row.appendChild(document.createElement("td"));
            // if (goal.updated_by) row.appendChild(cUpdatedBy);
            // else if (inputHiddenId)
            //     row.appendChild(document.createElement("td"));
            // row.appendChild(cButton);

            tableGoals.appendChild(row);
        });
        verifyGoals();
    };

    // Updated self qualification
    if (selfQualifacationButton) {
        selfQualifacationButton.addEventListener("click", async () => {
            const items = goalsEvaluations.map((item) => ({
                id: item.id,
                self_qualification: Number(item.goal.self_qualification),
            }));
            const id_evaluation = inputHiddenIdEvaluation.value;

            Swal.fire({
                title: "¿Estás seguro de finalizar la autocalificación de los objetivos?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post("/api/evaluation/self-qualification", {
                            id_evaluation,
                            items,
                        });
                        window.location.reload();
                    } catch (error) {
                        console.log(error);
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

    // Updated average
    if (averageButton) {
        averageButton.addEventListener("click", async () => {
            const items = goalsEvaluations.map((item) => ({
                id: item.id,
                average: Number(item.goal.average),
            }));
            const id_evaluation = inputHiddenIdEvaluation.value;

            Swal.fire({
                title: "¿Estás seguro de finalizar la calificación de los objetivos?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post("/api/evaluation/average", {
                            id_evaluation,
                            items,
                        });
                        window.location.reload();
                    } catch (error) {
                        console.log(error);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Ocurrio un error al aprobar los objetivos, intentelo de nuevo",
                        });
                    }
                }
            });

            // const res = await axios.post(
            //     `/api/evaluations/${inputHiddenIdEvaluation.value}/self-qualification`,
            //     data
            // );
            // if (res.status === 200) {
            //     alert("Calificaciones guardadas correctamente");
            // }
        });
    }

    // Close evaluation
    if (closeButton) {
        closeButton.addEventListener("click", async () => {
            const id_evaluation = inputHiddenIdEvaluation.value;

            Swal.fire({
                title: "¿Estás seguro de finalizar la evaluación?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post("/api/evaluation/close", {
                            id_evaluation,
                        });
                        window.location.reload();
                    } catch (error) {
                        console.log(error);
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

    renderGoals();
});
