import DateRangePicker from "vanillajs-datepicker/DateRangePicker";
import "vanillajs-datepicker/css/datepicker-bulma.css";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    const elem = $("#date-range") || null;
    const el = document.createElement("input");
    const rangepicker = new DateRangePicker(elem ?? el, {
        format: "yyyy-mm-dd",
    });

    const buttonFilter = $("#filter");

    filter?.addEventListener("click", () => {
        const dates = rangepicker.getDates();
        console.log(dates);
    });
});
