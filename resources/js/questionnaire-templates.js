import Sortable from "html5sortable/dist/html5sortable.es.js";
import { arrayMoveMutable } from "array-move";
import { v4 as uuidv4 } from "uuid";

document.addEventListener("DOMContentLoaded", async () => {
    const $ = document.querySelector.bind(document);
    const $questions = $("#questions");
    const $questionTemplate = $("#question-template")?.content;
    const $form = $("#template-form");
    const $template_id = $("#template_id");
    const $add = $("#add-question-button");

    let questions = [
        {
            _id: uuidv4(),
            id: null,
            question: null,
        },
    ];

    let deleteIds = [];

    // UI Events
    const initSortable = () => {
        const sortableInstance = Sortable($questions, {
            forcePlaceholderSize: true,
            placeholderClass:
                "cursor-grabbing w-[calc(33.21%-30px)] [&>td]:rounded-lg bg-white border border-white",
            handle: ".inner-handle",
        })[0];

        sortableInstance.removeEventListener("sortupdate", handleSortUpdate);
        sortableInstance.addEventListener("sortupdate", handleSortUpdate);
    };

    const handleSortUpdate = ({ detail: { origin, destination } }) => {
        arrayMoveMutable(questions, origin.index, destination.index);
        renderQuestions();
    };

    $add?.addEventListener("click", () => {
        questions.push({
            _id: uuidv4(),
            id: null,
            question: "",
        });
        renderQuestions();
    });

    function renderQuestions() {
        if (!$questions) return;
        $questions.innerHTML = "";

        questions.forEach((question, i) => {
            const $clone = document.importNode($questionTemplate, true);
            const $question = $clone.querySelector(".question");
            const $delete = $clone.querySelector(".delete");

            $question.innerHTML = question.question;
            $question.onpaste = window.onPaste;

            $question.ariaPlaceholder = `Agrega la pregunta ${i + 1}`;
            $question.innerHTML = question.question;
            $question.oninput = (e) => {
                questions[i].question = e.target.innerHTML;
            };

            $delete.addEventListener("click", () => {
                questions = questions.filter((q) => q._id !== question._id);
                if (question.id) {
                    deleteIds.push(question.id);
                }
                renderQuestions();
            });

            $questions.appendChild($clone);
        });

        initSortable();
    }
    renderQuestions();
    $form?.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (questions.length === 0) {
            return window.alert("Hey..!", "Agrega al menos una pregunta.");
        }

        const perQuestionIsValid = questions.every((q) => q.question);
        if (!perQuestionIsValid) {
            return window.alert(
                "Hey..!",
                "Por favor completa todas las preguntas."
            );
        }

        await window.mutation(
            $template_id
                ? `/api/questionnaire-templates/${$template_id.value}`
                : "/api/questionnaire-templates",
            {
                ...Object.fromEntries(new FormData($form)),
                questions,
                deleteIds,
            },
            "Guardar plantilla",
            "¿Estás seguro de guardar la plantilla?",
            "/edas/questionnaire-templates"
        );
    });

    if ($template_id) {
        const id = $template_id.value;
        const data = await window.query(
            `/api/questionnaire-templates/${id}/questions`
        );

        questions = data?.map((q) => ({
            _id: uuidv4(),
            id: q.id,
            question: q.question,
        }));

        renderQuestions();
    }
});
