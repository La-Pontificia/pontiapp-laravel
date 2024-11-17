import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const URL_SUNAT = "https://apisunat.daustinn.com";

    const $searchPersonForm = $("#search_person");
    const $ticketForm = $("#ticket_form");
    const regexDni = /^[0-9]{8}$/;

    $searchPersonForm?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const form = new FormData($searchPersonForm);

        const documentId = form.get("document-id");
        if (!regexDni.test(documentId)) return;

        try {
            const { data } = await axios.get(
                `${URL_SUNAT}/queries/dni?number=${documentId}`,
                {
                    headers: {
                        authorization: "Bearer univercelFree",
                    },
                }
            );

            if (data.status) {
                const paternalSurname = data.credentials.apellidoPaterno;
                const maternalSurname = data.credentials.apellidoMaterno;
                const names = data.credentials.nombres;
                const documentId = data.credentials.numeroDocumento;

                $("#paternal-surname").value = paternalSurname;
                $("#maternal-surname").value = maternalSurname;
                $("#names").value = names;
                $("#document-id").value = documentId;
            } else {
                alert("No se encontraron datos para el DNI ingresado");
            }
        } catch (error) {
            console.error(error);
            alert("Error al buscar los datos del DNI");
        }
    });

    $ticketForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData($ticketForm);

        window.disabledFormChildren($ticketForm);

        axios
            .post("/api/tickets", formData)
            .then((response) => {
                const pdfUrl = response.data;
                window.open(pdfUrl, "_blank");
                window.location.reload();
            })
            .catch(() => {
                alert("Error al generar el ticket");
            })
            .finally(() => {
                window.enabledFormChildren($ticketForm);
            });
    });

    $("#maximize-create-ticket-fast-panel")?.addEventListener("click", () => {
        const $panel = $("#create-ticket-fast-panel");
        if (!$panel) return;

        const maximize = $panel.hasAttribute("data-maximize");

        if (maximize) {
            $panel.removeAttribute("data-maximize");
        } else {
            $panel.setAttribute("data-maximize", "");
        }
    });

    let inputBuffer = "";

    if ($("#listening-barcode")) {
        document.addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                procesarEntrada(inputBuffer);
                inputBuffer = "";
            } else {
                inputBuffer += event.key;
            }
        });

        function procesarEntrada(data) {
            inputBuffer = "";
            console.log(data);
        }
    }

    // const listonTickets = $("#listen_to_tickets");

    // if (listonTickets) {
    //     const $tbody = $("#tickets_tbody");
    //     window.Echo.channel("tickets").listen(".ticketListUpdated", (event) => {
    //         console.log(event.tickets);
    //     });
    // }
});
