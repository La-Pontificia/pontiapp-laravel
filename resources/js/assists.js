import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import moment from "moment";
import axios from "axios";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    const idUser = $("#id_user");

    const buttonCreate = $("#button-create-scheldule-modal");
    const buttonClose = $("#button-close-scheldule-modal");
    const fromInput = $("#from-input");
    const toInput = $("#to-input");
    const startInput = $("#start-input");
    const endInput = $("#end-input");
    const formSchedule = $("#schedule-form");

    const calendarEl = $("#calendar");

    const calendar = new Calendar(calendarEl, {
        plugins: [timeGridPlugin, interactionPlugin, dayGridPlugin],
        locale: "es",
        customButtons: {
            customAddSchedule: {
                text: "Agregar Horario",
                click: function () {
                    buttonCreate.click();
                },
            },
        },
        headerToolbar: {
            left: "prev,next customAddSchedule",
            center: "title",
            right: "timeGridWeek,timeGridDay", // user can switch between the two
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Dia",
        },
        navLinks: true,
        hiddenDays: [0],
        editable: true,
        selectable: true,
        unselectAuto: true,
        eventOverlap: false,
        allDaySlot: false,
        slotDuration: "00:30",
        eventStartEditable: false,
        eventDurationEditable: false,
        slotLabelInterval: "00:30",
        longPressDelay: 0,
        slotMinTime: "05:00",
        slotMaxTime: "23:00",
        nowIndicator: "true",
        hiddenDays: [0],
        slotLabelFormat: {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
            meridiem: "short",
        },
        initialDate: "2024-07-08",
        initialView: "timeGridWeek",
        selectMirror: true,
        // events: [
        //     {
        //         start: "2014-11-10T10:00:00",
        //         end: "2014-11-10T13:20:00",
        //         display: "background",
        //     },
        // ],
        // dateClick: function (info) {
        //     alert("Clicked on: " + info.dateStr);
        //     alert(
        //         "Coordinates: " + info.jsEvent.pageX + "," + info.jsEvent.pageY
        //     );
        //     alert("Current view: " + info.view.type);
        //     // // change the day's background color just for fun
        //     // info.dayEl.style.backgroundColor = "red";
        // },
        // dateClick: function (info) {
        //     alert("clicked " + info.dateStr);
        // },
        select: function (info) {
            const start = info.start;
            const end = info.end;

            const startStr = `${start
                .getHours()
                .toString()
                .padStart(2, "0")}:${start
                .getMinutes()
                .toString()
                .padStart(2, "0")}`;
            const endStr = `${end.getHours().toString().padStart(2, "0")}:${end
                .getMinutes()
                .toString()
                .padStart(2, "0")}`;

            startInput.value = start.toISOString().split("T")[0];
            endInput.value = end.toISOString().split("T")[0];

            fromInput.value = startStr;
            toInput.value = endStr;

            buttonCreate.click();
        },
    });

    const updateEventSource = (schedules) => {
        calendar.addEventSource({
            events: schedules.map((event) => ({
                title: event.title,
                start: event.from,
                end: event.to,
                backgroundColor: event.background,
                borderColor: "white",
            })),
        });
    };

    if (idUser) {
        const { data } = await axios.get(`/api/schedules/${idUser.value}`);

        updateEventSource(data);
    }

    calendar.render();

    formSchedule?.addEventListener("submit", function (e) {
        e.preventDefault();
        const formValue = Object.fromEntries(new FormData(e.target));
        const days = Array.from(
            formSchedule.querySelectorAll('input[name="days[]"]:checked')
        ).map((input) => parseInt(input.value));

        const startDate = new Date(moment(formValue.start));
        const endDate = new Date(moment(formValue.end));
        const from = formValue.from;
        const to = formValue.to;

        const { schedule, currentDate } = generateSchedule(
            startDate,
            endDate,
            days,
            from,
            to
        );

        if (schedule.length === 0) {
            return window.toast.fire({
                icon: "warning",
                title: "No es posible crear un horario sin días seleccionados.",
            });
        }

        // sumary
        const dayNames = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        const selectedDayNames = days
            .map((day) => dayNames[day - 1])
            .join(", ");

        const endSumary = endDate
            ? ` hasta el ${moment(endDate).format("YYYY-MM-DD")}`
            : "";

        const summary = `Se produce cada ${selectedDayNames} empezando el ${moment(
            currentDate
        ).format("YYYY-MM-DD")} ${endSumary}`;

        Swal.fire({
            title: "¿Estas seguro de guardar este horario?",
            text: summary,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: `Sí, guardar`,
            cancelButtonText: "Cancelar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const jsonData = {
                    id_user: formValue.user,
                    start_date: moment(startDate).format("YYYY-MM-DD"),
                    end_date: moment(endDate).format("YYYY-MM-DD"),
                    from,
                    to,
                    days,
                    title: formValue.title,
                };

                try {
                    const res = await axios.post("/api/schedules", jsonData);
                    buttonClose.click();
                    updateEventSource(res.data);
                    formSchedule.reset();
                } catch (error) {
                    console.error(error);
                }
            }
        });
    });
});

const generateSchedule = (startDate, endDate, days, from, to) => {
    let schedule = [];
    let currentDate = new Date(startDate);

    while (currentDate <= endDate) {
        const dayOfWeek = currentDate.getDay() + 1;
        if (days.includes(dayOfWeek)) {
            schedule.push({
                date: moment(currentDate).format("YYYY-MM-DD"),
                from,
                to,
            });
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return { schedule, currentDate };
};
