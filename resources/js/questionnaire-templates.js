import Sortable from "html5sortable/dist/html5sortable.es.js";
import { arrayMoveMutable } from "array-move";
import axios from "axios";

document.addEventListener("DOMContentLoaded", async () => {
    const $ = document.querySelector.bind(document);
    const $questions = $("#questions");
    const $questionTemplate = $("#question-template")?.content;
    const $form = $("#template-form");

    let questions = [
        {
            _id: window.crypto.randomUUID(),
            id: null,
            question: null,
        },
    ];

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
    const $add = $("#add-question-button");
    $add?.addEventListener("click", () => {
        questions.push({
            _id: window.crypto.randomUUID(),
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
                renderQuestions();
            });

            $questions.appendChild($clone);
        });

        initSortable();
    }
    renderQuestions();

    // Form submit

    $form?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const perQuestionIsValid = questions.every((q) => q.question);
        if (!perQuestionIsValid) {
            return Swal.fire({
                icon: "warning",
                title: "Hey..!",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: "Por favor completa todas las preguntas.",
            });
        }

        try {
            const { data } = await axios.post("/api/questionnaire-templates", {
                ...Object.fromEntries(new FormData($form)),
                questions,
            });
            Swal.fire({
                icon: "success",
                title: "Hecho",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: data ?? "Formulario enviado correctamente",
            }).then(() => {
                window.location.href = "/edas/questionnaire-templates";
            });
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                text: error.response.data ?? "Error al enviar el formulario",
            });
        }
    });
});
