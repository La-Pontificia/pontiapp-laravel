import moment from "moment";

import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    let schedulesGroup = [];
    const group_id = $("#group-id");

    const calendarEl = $("#calendar-schedules");

    const buttonDeleteSchedule = document.querySelectorAll(
        ".delete-schelude-group"
    );

    // create element example
    const elem = document.createElement("div");

    const calendar = new Calendar(calendarEl ?? elem, {
        plugins: [timeGridPlugin, interactionPlugin, dayGridPlugin],
        locale: "es",
        headerToolbar: {
            left: "prev,next",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Dia",
        },
        navLinks: true,
        hiddenDays: [0],
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
        initialView: "timeGridWeek",
        selectMirror: true,
        dayHeaderContent: (args) => {
            const day = args.date.getDate();
            const dayName = args.date.toLocaleDateString("es-ES", {
                weekday: "short",
            });
            const displayDay =
                dayName.charAt(0).toUpperCase() + dayName.slice(1);
            return `${displayDay}, ${day}`;
        },
    });

    const updateEventSource = (events) => {
        calendar.addEventSource({
            events,
        });
    };

    if (group_id) {
        const { data } = await axios.get(
            `/api/schedules/group/${group_id.value}`
        );
        const groupEvents = data.map((schedule) => {
            const startDate = new Date(moment(schedule.start_date));
            const endDate = new Date(moment(schedule.end_date));
            const from = schedule.from;
            const to = schedule.to;
            return generateEvents(
                {
                    startDate,
                    endDate,
                    days: schedule.days,
                    from,
                    to,
                },
                schedule
            ).map((item) => ({
                ...item,
                title: schedule.title,
                backgroundColor: schedule.background,
                borderColor: schedule.background,
            }));
        });

        schedulesGroup = groupEvents.flat();
        updateEventSource(groupEvents.flat());
    }

    const schels = document.querySelectorAll(".schedule");

    schels?.forEach((schedule) => {
        schedule.addEventListener("click", async () => {
            const id = schedule.dataset.id;
            const hasSelected = schedule.hasAttribute("data-active");

            const hasAllSelected =
                document.querySelectorAll(".schedule[data-active]").length ===
                schels.length;

            schels.forEach((item) => {
                if (hasSelected && !hasAllSelected) {
                    item.setAttribute("data-active", true);
                } else {
                    item.removeAttribute("data-active");
                }
            });

            schedule.setAttribute("data-active", true);

            calendar.removeAllEvents();

            if (hasSelected && !hasAllSelected)
                updateEventSource(schedulesGroup);
            else {
                updateEventSource(
                    schedulesGroup.filter((item) => item.id === id)
                );
            }
        });
    });

    /// delete

    buttonDeleteSchedule?.forEach((button) => {
        const id = button.dataset.id;
        button.addEventListener("click", async () => {
            Swal.fire({
                title: "¿Estás seguro de eliminar el horario?",
                text: "No podrás deshacer esta acción.",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post(`/api/scheldules/delete/${id}`);
                        window.location.reload();
                    } catch (error) {
                        window.toast.fire({
                            icon: "error",
                            title: error.response.data ?? "Error",
                        });
                    }
                }
            });
        });
    });

    calendar.render();
});

const generateEvents = ({ startDate, endDate, days, from, to }, schedule) => {
    let schedules = [];
    let currentDate = new Date(startDate);
    const endDateObj = new Date(endDate);

    while (currentDate <= endDateObj) {
        const dayOfWeek = currentDate.getDay() + 1;

        if (days.includes(dayOfWeek.toString())) {
            const date = moment(currentDate).format("YYYY-MM-DD");
            schedules.push({
                ...schedule,
                start: `${date} ${from.split(" ")[1]}`,
                end: `${date} ${to.split(" ")[1]}`,
            });
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return schedules;
};
