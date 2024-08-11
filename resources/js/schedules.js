import moment from "moment";

import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);

    let schedules = [];
    const group_id = $("#group-id");
    const user_id = $("#user-id");
    const calendarEl = $("#calendar-schedules");

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

    const $schedulesParent = $("#schedules");
    const $schedules = $schedulesParent?.querySelectorAll(".schedule");

    $schedules?.forEach(($schedule) => {
        $schedule.addEventListener("click", async () => {
            const id = $schedule.dataset.id;
            const hasSelected = $schedule.hasAttribute("data-active");

            const hasAllSelected =
                $schedulesParent.querySelectorAll(".schedule[data-active]")
                    .length === $schedules.length;

            $schedules.forEach((item) => {
                item.removeAttribute("data-active");
            });

            if (hasSelected && !hasAllSelected) {
                $schedules.forEach((item) => {
                    item.setAttribute("data-active", true);
                });
            }

            calendar.removeAllEvents();

            if (hasSelected && hasAllSelected) updateEventSource(schedules);
            else if (hasSelected && !hasAllSelected) {
                updateEventSource(schedules);
            } else {
                updateEventSource(schedules.filter((item) => item.id === id));
            }

            $schedule.setAttribute("data-active", true);
        });
    });

    if (group_id || user_id) {
        const uri = group_id
            ? `/api/schedules/group/${group_id.value}`
            : `/api/schedules/user/${user_id.value}`;

        const data = await window.query(uri);

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

        schedules = groupEvents.flat();
        updateEventSource(groupEvents.flat());
    }

    calendar.render();
});

const generateEvents = ({ startDate, endDate, days, from, to }, schedule) => {
    let schedules = [];
    let currentDate = new Date(startDate);
    const endDateObj = new Date(endDate);

    while (currentDate <= endDateObj) {
        const dayOfWeek = currentDate.getDay();

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
