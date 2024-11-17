document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const $searchInput = $("#search-input");
    const $searchResult = $("#search-result");
    const $searchEmptyResult = $("#search-empty-result");
    const $searchNotmatchResult = $("#search-notmatch-result");

    const $itemTemplate = $("#search-item-template");

    let debounceTimer;

    $searchInput?.addEventListener("input", (e) => {
        if (!e.target.value.length) {
            $searchEmptyResult.setAttribute("data-open", "");
            $searchNotmatchResult.removeAttribute("data-open", "");
            $searchResult.innerHTML = "";
            clearTimeout(debounceTimer);
            return;
        }
        $searchEmptyResult.removeAttribute("data-open", "");
        $searchNotmatchResult.removeAttribute("data-open", "");

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = e.target.value;
            fetch(`/api/users/search/quick?query=${query}`)
                .then((res) => res.json())
                .then((data) => {
                    $searchResult.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach((user) => {
                            const $item = $itemTemplate.content.cloneNode(true);
                            $item.querySelector("a").href = `/users/${user.id}`;
                            $item.querySelector("h2").textContent =
                                user.full_name;
                            $item.querySelector("p").textContent =
                                user.role_position;
                            $searchResult.appendChild($item);
                        });
                    } else {
                        $searchNotmatchResult.setAttribute("data-open", "");
                    }
                })
                .catch((err) => {
                    console.error(err);
                    alert("Something went wrong, please try again later.");
                });
        }, 200);
    });
});
