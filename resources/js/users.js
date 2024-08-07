import moment from "moment";
import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

const regexDni = /^[0-9]{8}$/;

const capitalize = (str) =>
    str
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");

document.addEventListener("DOMContentLoaded", async () => {
    const URL_SUNAT = "https://apisunat.daustinn.com";

    $ = document.querySelector.bind(document);

    const UserForm = $("#reate-user-form");
    const InputDni = $("#dni-input");
    const InputFirstName = $("#first_name-input");
    const InputLastName = $("#last_name-input");
    const JobPositionSelect = $("#job-position-select");
    const RoleSelect = $("#role-select");

    const inputProfile = $("#input-profile");
    const previewProfile = $("#preview-profile");

    // SET PROFILE
    inputProfile?.addEventListener("change", async (e) => {
        const file = e.target.files[0];
        const isUpdated = inputProfile.getAttribute("data-userid");
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            previewProfile.src = reader.result;
        };

        if (isUpdated) {
            try {
                const form = new FormData();

                const f = new File([file], "profile.jpg", {
                    type: "image/jpeg",
                });

                form.append("file", f);
                form.append("upload_preset", "ztmbixcz");
                form.append("folder", "eda");

                const res = await axios.post(
                    "https://api.cloudinary.com/v1_1/dc0t90ahb/upload",
                    form,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                const uri = res.data.secure_url;
                const id = inputProfile.getAttribute("data-userid");

                await axios.post(`/api/users/${id}/profile`, { profile: uri });

                window.toast.fire({
                    icon: "info",
                    title: "Imagen de perfil actualizada",
                });
            } catch (error) {
                console.error(error);
                window.toast.fire({
                    icon: "error",
                    title:
                        error.response.data ?? "Error al enviar el formulario",
                });
            }
        }
    });

    // GET PUESTOS
    JobPositionSelect?.addEventListener("change", async (e) => {
        const id = e.target.value;
        try {
            const res = await axios.get(`/api/roles/by_job_position/${id}`);
            const roles = res.data;

            RoleSelect.innerHTML = "";

            roles.forEach((role) => {
                const option = document.createElement("option");
                option.value = role.id;
                option.textContent = `Cargo: ${role.name}`;
                RoleSelect.appendChild(option);
            });
        } catch (error) {
            console.error(error);
        }
    });

    // SEARCH USER BY SUNAT
    InputDni?.addEventListener("input", async (e) => {
        const dni = e.target.value;
        if (!regexDni.test(dni)) return;

        try {
            const { data } = await axios.get(
                `${URL_SUNAT}/queries/dni?number=${dni}`,
                {
                    headers: {
                        authorization: "Bearer univercelFree",
                    },
                }
            );

            InputFirstName.value = capitalize(data.credentials.nombres);
            InputLastName.value = capitalize(
                data.credentials.apellidoPaterno +
                    " " +
                    data.credentials.apellidoMaterno
            );
        } catch (error) {
            console.error(error);
        }
    });

    // CREATE/UPDATE USER
    UserForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);

        const dni = form.get("dni");

        // validate dni
        if (!regexDni.test(dni)) {
            return window.toast.fire({
                icon: "error",
                title: "El DNI debe tener 8 caracteres",
            });
        }

        window.disabledFormChildren(UserForm);

        const image = form.get("profile");

        if (image instanceof File && image.size > 0) {
            try {
                const formImage = new FormData();

                const file = new File([image], "profile.jpg", {
                    type: "image/jpeg",
                });

                formImage.append("file", file);
                formImage.append("upload_preset", "ztmbixcz");
                formImage.append("folder", "eda");

                const res = await axios.post(
                    "https://api.cloudinary.com/v1_1/dc0t90ahb/upload",
                    formImage,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                form.set("profile", res.data.secure_url);
            } catch (error) {
                console.error(error);
            } finally {
                window.enabledFormChildren(UserForm);
            }
        }
        form.delete("profile");

        try {
            const { data } = await axios.post(
                "/api/users",
                Object.fromEntries(form)
            );
            window.location.href = `/users/${data.id}`;
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                text: error.response.data ?? "Error al registrar el usuario",
            });
        } finally {
            window.enabledFormChildren(UserForm);
        }
    });

    // SLUG SCHEDULE USER
    let schedules = [];
    const userid = $("#user_id");

    const calendarEl = $("#calendar-user-slug");

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

    if (userid) {
        const { data } = await axios.get(`/api/schedules/user/${userid.value}`);
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

            if (hasSelected && !hasAllSelected) updateEventSource(schedules);
            else {
                updateEventSource(schedules.filter((item) => item.id === id));
            }
        });
    });

    calendar.render();

    // supervisor assign

    // add supervisor to user
    const inputs = document.querySelectorAll(".supervisor-input");
    const itemSupervisorTemplate = $("#item-supervisor-template")?.content;
    inputs.forEach((f) => {
        f.addEventListener(
            "input",
            window.debounce(async (e) => {
                const id = f.getAttribute("data-id");
                const value = e.target.value;
                const resultContainer = $(`#result-${id}`);

                if (!value)
                    return (resultContainer.innerHTML = `<p class="p-10 text-neutral-500">
                         No se encontraron resultados o no se ha realizado una búsqueda.
                     </p>`);

                const { data: users } = await axios.get(
                    `/api/users/supervisor/${id}/search?query=${value}`
                );

                resultContainer.innerHTML = "";
                users.forEach((user) => {
                    const clone = document.importNode(
                        itemSupervisorTemplate,
                        true
                    );

                    clone.querySelector(
                        ".result-title"
                    ).textContent = `${user.last_name}, ${user.first_name}`;

                    clone.querySelector(".result-email").textContent =
                        user.email;

                    if (user.profile) {
                        clone.querySelector("img").src = user.profile;
                    } else {
                        clone.querySelector("img").remove();
                    }

                    clone
                        .querySelector("button")
                        .addEventListener("click", async () => {
                            clone.disabled = true;
                            try {
                                await axios.post(
                                    `/api/users/supervisor/assign/${id}`,
                                    {
                                        supervisor_id: user.id,
                                    }
                                );
                                window.location.reload();
                            } catch (error) {
                                window.toast.fire({
                                    icon: "error",
                                    title:
                                        error.response.data ??
                                        "Ocurrió un error al intentar asignar el supervisor",
                                });
                            } finally {
                                clone.disabled = false;
                            }
                        });

                    resultContainer.appendChild(clone);
                });
            }, 300)
        );
    });
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
