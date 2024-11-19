import confetti from "canvas-confetti";
import Cookies from "js-cookie";

document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const $searchInput = $("#search-input");
    const $searchResult = $("#search-result");
    const $searchEmptyResult = $("#search-empty-result");
    const $searchNotmatchResult = $("#search-notmatch-result");
    const $itemTemplate = $("#search-item-template");

    let debounceTimer;
    let abortController;
    const cache = {};

    $searchInput?.addEventListener("input", (e) => {
        const query = e.target.value.trim();

        if (!query.length) {
            $searchEmptyResult.setAttribute("data-open", "");
            $searchNotmatchResult.removeAttribute("data-open", "");
            $searchResult.innerHTML = "";
            clearTimeout(debounceTimer);

            if (abortController) abortController.abort();
            return;
        }

        $searchEmptyResult.removeAttribute("data-open", "");
        $searchNotmatchResult.removeAttribute("data-open", "");
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            // Cancelar solicitudes anteriores
            if (abortController) abortController.abort();

            // Verificar si la consulta ya está en caché
            if (cache[query]) {
                renderResults(cache[query]);
                return;
            }

            // Crear un nuevo AbortController
            abortController = new AbortController();
            const signal = abortController.signal;

            fetch(`/api/users/search/quick?query=${query}`, { signal })
                .then((res) => {
                    if (!res.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return res.json();
                })
                .then((data) => {
                    // Almacenar en caché los resultados
                    cache[query] = data;
                    renderResults(data);
                })
                .catch((err) => {
                    if (err.name === "AbortError") {
                        return; // Ignorar errores por abortar la solicitud
                    }
                    console.error(err);
                    alert("Something went wrong, please try again later.");
                });
        }, 200);
    });

    function renderResults(data) {
        $searchResult.innerHTML = "";
        if (data.length > 0) {
            data.forEach((user) => {
                const $item = $itemTemplate.content.cloneNode(true);
                $item.querySelector("a").href = `/users/${user.id}`;
                $item.querySelector("h2").textContent = user.full_name;
                $item.querySelector("p").textContent = user.role_position;
                $searchResult.appendChild($item);
            });
        } else {
            $searchNotmatchResult.setAttribute("data-open", "");
        }
    }

    // modal birthday
    if ($("#birthday-modal")) {
        var duration = 15 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = {
            startVelocity: 30,
            spread: 360,
            ticks: 60,
            zIndex: 9999,
        };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        var interval = setInterval(function () {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            confetti({
                ...defaults,
                particleCount,
                origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
            });
            confetti({
                ...defaults,
                particleCount,
                origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
            });
        }, 250);

        Cookies.set("showedBirthdayModal", "true", {
            expires: 1,
            path: "/",
        });
    }

    $$(".close-birthday-modal").forEach((el) => {
        el.addEventListener("click", function () {
            $("#birthday-modal").remove();
            $("#birthday-modal-overlay").remove();
        });
    });
});
