import moment from "moment";
import { DateRangePicker } from "vanillajs-datepicker";
import "vanillajs-datepicker/css/datepicker-bulma.css";
import "vanillajs-datepicker/locales/es";

document.addEventListener("DOMContentLoaded", async () => {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const elements = $$(".date-range");

    elements?.forEach(($elem) => {
        const el = document.createElement("div");

        const startDate = moment().format("YYYY-MM-DD");
        const endDate = moment().format("YYYY-MM-DD");

        const rangepicker = new DateRangePicker($elem ?? el, {
            format: "yyyy-mm-dd",
            clearButton: true,
            enableOnReadonly: true,
            language: "es",
        });

        const element = $elem ?? el;
        const [startInput, endInput] = element?.querySelectorAll("input");
        const startDefault = startInput?.getAttribute("data-default");
        const endDefault = endInput?.getAttribute("data-default");

        if (startInput && endInput) {
            rangepicker.setDates(
                startDefault ?? startDate,
                endDefault ?? endDate
            );
        }
    });
});
