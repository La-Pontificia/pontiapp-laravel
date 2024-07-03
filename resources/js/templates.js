document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    let questions = [
        {
            id: 1,
            question: "",
            is_new: true,
            order: 1,
        },
    ];

    let questions_to_delete = [];

    const addQuestionButton = $("#add-question-button");
    const questionsTable = $("#questions-table");
    const scrollQuestionTable = $("#scroll-questions-table");
    const form = $("#template-form");

    const buttonsChangeInUse = document.querySelectorAll(
        ".change-template-in-use"
    );

    const hasId = $("#has-id");

    // fetch questions if hasId exists
    if (hasId) {
        const res = await axios.get(
            `/api/questions/by-template/${hasId.value}`
        );
        questions = [];
        res.data.map((question) => {
            questions.push({
                id: question.id,
                is_new: false,
                question: question.question,
                order: question.order,
            });
        });
    }

    function renderQuestions() {
        if (!questionsTable) return;
        questionsTable.innerHTML = "";

        questions
            .sort((a, b) => a.order - b.order)
            .forEach((question, index) => {
                const row = document.createElement("tr");
                row.className =
                    "[&>td>div]:p-2 [&>td]:align-top [&>td>div]:rounded-lg";

                // Question column
                const divQuestion = document.createElement("div");
                divQuestion.contentEditable = true;
                divQuestion.className =
                    "min-h-[100px] overflow-x-auto text-indigo-700 w-[450px]";
                divQuestion.ariaPlaceholder = `Agrega la pregunta ${index + 1}`;
                divQuestion.innerHTML = question.question;
                divQuestion.oninput = (e) => {
                    questions[index].question = e.target.innerHTML;
                };
                divQuestion.onpaste = window.onPaste;

                // Order column
                const inputOrder = document.createElement("input");
                inputOrder.className =
                    "bg-neutral-100 m-1 text-center w-12 border-2 border-neutral-400 p-1 px-2 rounded-lg";
                inputOrder.placeholder = "0";
                inputOrder.type = "number";
                inputOrder.min = 1;
                inputOrder.value = question.order;
                inputOrder.onblur = (e) => {
                    const order = e.target.value;
                    const questionPrevOrder = questions[index].order;
                    questions[index].order =
                        order < 1 ? questionPrevOrder : order;
                    renderQuestions();
                };

                // Button column
                const deleteButton = document.createElement("button");
                deleteButton.className =
                    "bg-neutral-200 hover:bg-neutral-300 px-2 m-1 rounded-md p-2 text-sm font-semibold";
                deleteButton.type = "button";
                deleteButton.innerText = "Remover";
                deleteButton.onclick = () => {
                    questions = questions.filter((q) => q.id !== question.id);
                    if (!question.is_new) {
                        questions_to_delete.push(question.id);
                    }
                    renderQuestions();
                };

                const cQuestion = document.createElement("td");
                cQuestion.appendChild(divQuestion);

                const inputQuestion = document.createElement("td");
                inputQuestion.appendChild(inputOrder);

                const buttonQuestion = document.createElement("td");
                buttonQuestion.appendChild(deleteButton);

                row.appendChild(cQuestion);
                row.appendChild(inputQuestion);
                row.appendChild(buttonQuestion);

                questionsTable.appendChild(row);
            });
    }

    addQuestionButton?.addEventListener("click", () => {
        questions.push({
            id: questions.length + 1,
            question: "",
            is_new: true,
            order: questions.length + 1,
        });

        // scrollQuestionTable srcoll to bottom
        scrollQuestionTable.scrollTop = scrollQuestionTable.scrollHeight;

        renderQuestions();
    });

    renderQuestions();

    // Form submit
    form?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const isInvalid = questions.some(
            (question) => question.question === "" || question.order === ""
        );
        if (isInvalid) {
            return window.Toast.fire({
                icon: "warning",
                title: "Por favor, complete todos los campos",
            });
        }

        const url = hasId ? `/api/templates/${hasId.value}` : "/api/templates";

        const buttonSubmitByFormId = document.querySelector(
            `button[form="${form.id}"]`
        );

        window.disabledFormChildren(form);
        window.disabledComponents([buttonSubmitByFormId]);

        try {
            await axios.post(url, {
                title: formData.get("title"),

                for: formData.get("for"),

                questions_to_create: questions.filter(
                    (question) => question.is_new
                ),

                questions_to_update: questions.filter(
                    (question) => !question.is_new
                ),

                questions_to_delete,
            });
            window.location.href = "/templates";
        } catch (error) {
            console.error(error);
            Toast.fire({
                icon: "error",
                title: error.response.data ?? "Error al enviar el formulario",
            });
        } finally {
            window.enableFormChildren(form);
            window.enableComponents([buttonSubmitByFormId]);
        }
    });

    // Change in use

    buttonsChangeInUse.forEach((button) => {
        button.addEventListener("click", async () => {
            const templateId = button.getAttribute("data-id");
            const url = `/api/templates/${templateId}/change-in-use`;

            try {
                await axios.post(url);
                window.location.reload();
            } catch (error) {
                console.error(error);
                Toast.fire({
                    icon: "error",
                    title:
                        error.response.data ??
                        "Error al cambiar el estado de la plantilla",
                });
            }
        });
    });
});
