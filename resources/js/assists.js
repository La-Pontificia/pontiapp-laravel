import ExcelJS from "exceljs";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const exportButton = $("#button-export-assists");

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

    // const idUser = $("#id_user");

    // const buttonCreate = $("#button-create-scheldule-modal");
    // const buttonClose = $("#button-close-scheldule-modal");
    // const fromInput = $("#from-input");
    // const toInput = $("#to-input");
    // const startInput = $("#start-input");
    // const endInput = $("#end-input");
    // const formSchedule = $("#schedule-form");

    // const calendarEl = $("#calendar");

    // const calendar = new Calendar(calendarEl, {
    //     plugins: [timeGridPlugin, interactionPlugin, dayGridPlugin],
    //     locale: "es",
    //     customButtons: {
    //         customAddSchedule: {
    //             text: "Agregar Horario",
    //             click: function () {
    //                 buttonCreate.click();
    //             },
    //         },
    //     },
    //     headerToolbar: {
    //         left: "prev,next customAddSchedule",
    //         center: "title",
    //         right: "timeGridWeek,timeGridDay", // user can switch between the two
    //     },
    //     buttonText: {
    //         today: "Hoy",
    //         month: "Mes",
    //         week: "Semana",
    //         day: "Dia",
    //     },
    //     navLinks: true,
    //     hiddenDays: [0],
    //     editable: true,
    //     selectable: true,
    //     unselectAuto: true,
    //     eventOverlap: false,
    //     allDaySlot: false,
    //     slotDuration: "00:30",
    //     eventStartEditable: false,
    //     eventDurationEditable: false,
    //     slotLabelInterval: "00:30",
    //     longPressDelay: 0,
    //     slotMinTime: "05:00",
    //     slotMaxTime: "23:00",
    //     nowIndicator: "true",
    //     hiddenDays: [0],
    //     slotLabelFormat: {
    //         hour: "2-digit",
    //         minute: "2-digit",
    //         hour12: true,
    //         meridiem: "short",
    //     },
    //     initialView: "timeGridWeek",
    //     selectMirror: true,
    //     dayHeaderContent: (args) => {
    //         // format in example: "Vie 12, Juev 11, Sab 17, 29 etc.." in spanish
    //         const day = args.date.getDate();
    //         const dayName = args.date.toLocaleDateString("es-ES", {
    //             weekday: "short",
    //         });
    //         const displayDay =
    //             dayName.charAt(0).toUpperCase() + dayName.slice(1);
    //         return `${displayDay}, ${day}`;
    //     },
    //     // events: [
    //     //     {
    //     //         start: "2014-11-10T10:00:00",
    //     //         end: "2014-11-10T13:20:00",
    //     //         display: "background",
    //     //     },
    //     // ],
    //     // dateClick: function (info) {
    //     //     alert("Clicked on: " + info.dateStr);
    //     //     alert(
    //     //         "Coordinates: " + info.jsEvent.pageX + "," + info.jsEvent.pageY
    //     //     );
    //     //     alert("Current view: " + info.view.type);
    //     //     // // change the day's background color just for fun
    //     //     // info.dayEl.style.backgroundColor = "red";
    //     // },
    //     // dateClick: function (info) {
    //     //     alert("clicked " + info.dateStr);
    //     // },
    //     select: function (info) {
    //         const start = info.start;
    //         const end = info.end;

    //         const startStr = `${start
    //             .getHours()
    //             .toString()
    //             .padStart(2, "0")}:${start
    //             .getMinutes()
    //             .toString()
    //             .padStart(2, "0")}`;
    //         const endStr = `${end.getHours().toString().padStart(2, "0")}:${end
    //             .getMinutes()
    //             .toString()
    //             .padStart(2, "0")}`;

    //         startInput.value = start.toISOString().split("T")[0];
    //         endInput.value = end.toISOString().split("T")[0];

    //         fromInput.value = startStr;
    //         toInput.value = endStr;

    //         buttonCreate.click();
    //     },
    // });

    // const updateEventSource = (schedules) => {
    //     calendar.addEventSource({
    //         events: schedules.map((event) => ({
    //             title: event.title,
    //             start: event.from,
    //             end: event.to,
    //             backgroundColor: event.background,
    //             borderColor: "white",
    //         })),
    //     });
    // };

    // if (idUser) {
    //     const { data } = await axios.get(`/api/schedules/${idUser.value}`);
    //     updateEventSource(data);
    // }

    // calendar.render();

    // formSchedule?.addEventListener("submit", function (e) {
    //     e.preventDefault();
    //     const formValue = Object.fromEntries(new FormData(e.target));
    //     const days = Array.from(
    //         formSchedule.querySelectorAll('input[name="days[]"]:checked')
    //     ).map((input) => parseInt(input.value));

    //     const startDate = new Date(moment(formValue.start));
    //     const endDate = new Date(moment(formValue.end));
    //     const from = formValue.from;
    //     const to = formValue.to;

    //     const { schedule, currentDate } = generateSchedule(
    //         startDate,
    //         endDate,
    //         days,
    //         from,
    //         to
    //     );

    //     if (schedule.length === 0) {
    //         return window.toast.fire({
    //             icon: "warning",
    //             title: "No es posible crear un horario sin días seleccionados.",
    //         });
    //     }

    //     // sumary
    //     const dayNames = [
    //         "Domingo",
    //         "Lunes",
    //         "Martes",
    //         "Miércoles",
    //         "Jueves",
    //         "Viernes",
    //         "Sábado",
    //     ];
    //     const selectedDayNames = days
    //         .map((day) => dayNames[day - 1])
    //         .join(", ");

    //     const endSumary = endDate
    //         ? ` hasta el ${moment(endDate).format("YYYY-MM-DD")}`
    //         : "";

    //     const summary = `Se produce cada ${selectedDayNames} empezando el ${moment(
    //         currentDate
    //     ).format("YYYY-MM-DD")} ${endSumary}`;

    //     Swal.fire({
    //         title: "¿Estas seguro de guardar este horario?",
    //         text: summary,
    //         showCancelButton: true,
    //         confirmButtonColor: "#d33",
    //         cancelButtonColor: "#3085d6",
    //         confirmButtonText: `Sí, guardar`,
    //         cancelButtonText: "Cancelar",
    //     }).then(async (result) => {
    //         if (result.isConfirmed) {
    //             const jsonData = {
    //                 id_user: formValue.user,
    //                 start_date: moment(startDate).format("YYYY-MM-DD"),
    //                 end_date: moment(endDate).format("YYYY-MM-DD"),
    //                 from,
    //                 to,
    //                 days,
    //                 title: formValue.title,
    //             };

    //             try {
    //                 const res = await axios.post("/api/schedules", jsonData);
    //                 buttonClose.click();
    //                 updateEventSource(res.data);
    //                 formSchedule.reset();
    //             } catch (error) {
    //                 console.error(error);
    //             }
    //         }
    //     });
    // });
});
