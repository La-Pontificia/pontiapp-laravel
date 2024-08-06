import moment from "moment";
import { DateRangePicker } from "vanillajs-datepicker";
import "vanillajs-datepicker/css/datepicker-bulma.css";
import "vanillajs-datepicker/locales/es";
import ExcelJS from "exceljs";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    const elem = $("#date-range") || null;
    const el = document.createElement("div");

    const startDate = moment().startOf("month").format("YYYY-MM-DD");
    const endDate = moment().endOf("month").format("YYYY-MM-DD");

    const exportButton = $("#export-individuals-attendances");

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

    // Export attendances

    exportButton?.addEventListener("click", async () => {
        const table = $("#table-export-assists");
        const tbody = table.querySelector("tbody");
        const rows = tbody.querySelectorAll("tr");
        const attendances = [];

        rows.forEach((row) => {
            const columns = row.querySelectorAll("td");
            const ariahidden = row.getAttribute("aria-hidden");
            const dni = row.getAttribute("data-dni");
            const full_name = row.getAttribute("data-fullnames");
            if (ariahidden === "true") return;

            let item = {};
            columns.forEach((column) => {
                const value = column.getAttribute("data-value");
                const name = column.getAttribute("data-name");
                item = { ...item, [name]: value };
            });
            attendances.push({ ...item, dni, full_name });
        });

        const groupAssistances = attendances.reduce((acc, item) => {
            const { dni, full_name, ...rest } = item;
            const index = acc.findIndex((i) => i.dni === dni);
            if (index === -1) {
                acc.push({ dni, full_name, assistances: [rest] });
            } else {
                acc[index].assistances.push(item);
            }
            return acc;
        }, []);

        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet("Asistencias");

        worksheet.columns = [
            { header: "N°", key: "index" },
            { header: "DNI", key: "dni" },
            { header: "Nombres y Apellidos", key: "full_name" },
            { header: "Título", key: "title" },
            { header: "Fecha", key: "date" },
            { header: "Dia", key: "day" },
            { header: "Turno", key: "turn" },
            { header: "Entrada", key: "from" },
            { header: "Salida", key: "to" },
            { header: "Entró", key: "marked_in" },
            { header: "Salió", key: "marked_out" },
            { header: "Diferencia", key: "difference" },
            { header: "Terminal", key: "terminal" },
            { header: "Observaciones", key: "observations" },
        ];

        groupAssistances.forEach((item) => {
            worksheet.addRow({});
            item.assistances.forEach((assist, i) => {
                const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
                const row = worksheet.addRow({
                    index,
                    dni: item.dni,
                    full_name: item.full_name,
                    ...assist,
                });
                row.getCell("index").alignment = { horizontal: "left" };
            });
        });

        worksheet.columns.forEach((column) => {
            let maxLength = 0;
            column.eachCell({ includeEmpty: true }, (cell) => {
                const cellValue = cell.value ? cell.value.toString() : "";
                maxLength = Math.max(maxLength, cellValue.length);
            });
            column.width = maxLength < 10 ? 10 : maxLength + 2;
        });

        const dateRange = $("#date-range");
        const start = dateRange.querySelector("input[name=start]");
        const end = dateRange.querySelector("input[name=end]");

        const name = `Asistencias ${start.value} - ${end.value}.xlsx`;

        workbook.xlsx.writeBuffer().then((buffer) => {
            const blob = new Blob([buffer], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = name;
            link.click();
        });
    });
});
