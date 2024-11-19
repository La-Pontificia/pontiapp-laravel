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
    const cache = {}; // Objeto para almacenar la caché

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
});
