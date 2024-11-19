import axios from "axios";
import moment from "moment";
moment.locale("es");
import "moment/locale/es";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const $checkServer = $("#check-server");
    const $errorServer = $("#error-server");

    if ($checkServer) {
        $checkServer.innerHTML = "Verificando...";
        const { data } = await axios.get("/api/assists/check-server");
        if (data.status == "error") {
            $checkServer.innerHTML = data.message;
            $errorServer.innerHTML = data.error;
            $checkServer.classList.add("text-red-500");
        } else {
            $checkServer.innerHTML = data.message;
            $checkServer.classList.add("text-green-500");
        }
    }
});
