import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);

    const calendarEl = $("#calendar");

    const calendar = new Calendar(calendarEl, {
        plugins: [timeGridPlugin, interactionPlugin, dayGridPlugin],
        locale: "es",
        headerToolbar: {
            left: "prev,next",
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
        slotDuration: "00:15",
        eventStartEditable: false,
        eventDurationEditable: false,
        slotLabelInterval: "00:15",
        longPressDelay: 0,
        slotMinTime: "06:00",
        slotMaxTime: "21:00",
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
    });

    calendar.render();
});
