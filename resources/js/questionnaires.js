document.addEventListener("DOMContentLoaded", function () {
    const $$ = document.querySelectorAll.bind(document);
    const $ = document.querySelector.bind(document);

    const $collaborator = $("#questionnaire-collaborator-btn");
    const $collaboratorQuestions = $("#questionnaire-collaborator-questions");

    const $supervisor = $("#questionnaire-supervisor-btn");
    const $supervisorQuestions = $("#questionnaire-supervisor-questions");

    $collaborator?.addEventListener("click", function (e) {
        const $questions = $collaboratorQuestions.querySelectorAll(
            "*[data-id-question]"
        );
        const id_eda = $collaboratorQuestions.getAttribute("data-id-eda");
        void sendQuestionnaire($questions, id_eda);
    });

    $supervisor?.addEventListener("click", function (e) {
        const $questions = $supervisorQuestions.querySelectorAll(
            "*[data-id-question]"
        );
        const id_eda = $supervisorQuestions.getAttribute("data-id");
        void sendQuestionnaire($questions, id_eda);
    });

    async function sendQuestionnaire($questions, id_eda) {
        let questions = [];

        $questions.forEach(($question) => {
            const question_id = $question.getAttribute("data-id-question");
            const answer = $question.innerText;
            questions.push({ question_id, answer });
        });

        const validate = questions.every((question) => {
            return question.question_id && question.answer;
        });

        if (!validate) {
            return window.alert(
                "Oops...",
                "Por favor, responde todas las preguntas"
            );
        }
        await window.mutation(
            `/api/edas/questionnaire/${id_eda}`,
            {
                answers: questions,
            },
            "Enviar cuestionario",
            "¿Estás seguro de enviar el cuestionario?"
        );
    }
});
