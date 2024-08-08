import moment from "moment";
import { DateRangePicker } from "vanillajs-datepicker";
import "vanillajs-datepicker/css/datepicker-bulma.css";
import "vanillajs-datepicker/locales/es";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    const elem = $("#date-range") || null;
    const el = document.createElement("div");

    const startDate = moment().startOf("month").format("YYYY-MM-DD");
    const endDate = moment().endOf("month").format("YYYY-MM-DD");

    const rangepicker = new DateRangePicker(elem ?? el, {
        format: "yyyy-mm-dd",
        clearButton: true,
        enableOnReadonly: true,
        language: "es",
    });

    const buttonFilter = $("#filter");

    const element = elem ?? el;
    const [startInput, endInput] = element?.querySelectorAll("input");
    const startDefault = startInput?.getAttribute("data-default");
    const endDefault = endInput?.getAttribute("data-default");

    if (startInput && endInput) {
        rangepicker.setDates(startDefault ?? startDate, endDefault ?? endDate);
    }

    buttonFilter?.addEventListener("click", () => {
        const dates = rangepicker.getDates();
        const params = new URLSearchParams(window.location.search);
        if (dates[0] && dates[1]) {
            params.set("start_date", moment(dates[0]).format("YYYY-MM-DD"));
            params.set("end_date", moment(dates[1]).format("YYYY-MM-DD"));
        } else {
            params.delete("start_date");
            params.delete("end_date");
        }
        window.location.search = params.toString();
    });
});
