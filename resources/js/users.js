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

    const searchSupervisor = $("#search-supervisor");
    const listUsers = $("#list-users");

    const inputProfile = $("#input-profile");
    const previewProfile = $("#preview-profile");

    const dischargeEmailButtons = document.querySelectorAll(".discharge-email");

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

    // SEARCH SUPERVISOR
    searchSupervisor?.addEventListener("input", async (e) => {
        const search = e.target.value;
        if (search === "") return searchSupervisor.setAttribute("data-id", "");
        if (search.length < 3) return;

        try {
            const { data } = await axios.get(
                `/api/users/search?query=${search}`
            );
            const users = data.users;

            listUsers.innerHTML = "";

            users.forEach((user) => {
                const button = document.createElement("button");
                button.type = "button";
                button.className =
                    "flex justify-start w-full hover:bg-neutral-200 p-1 rounded-md text-left items-center gap-2";
                button.innerHTML = `
                    <div class="w-10 aspect-square rounded-full overflow-hidden">
                        <img class="w-full h-full object-cover"
                            src="${user.profile}"
                            alt="">
                    </div>
                    <div>
                        <p class="font-semibold">
                            ${user.first_name} ${user.last_name}
                        </p>
                        <p>
                            ${user.dni}
                        </p>
                    </div>
                `;
                button.addEventListener("click", () => {
                    searchSupervisor.value = `${user.first_name} ${user.last_name}`;
                    searchSupervisor.setAttribute("data-id", user.id);
                    listUsers.innerHTML = "";
                });
                listUsers.appendChild(button);
            });
        } catch (error) {
            console.error(error);
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

    // DISCHARGE EMAIL
    dischargeEmailButtons?.forEach((button) => {
        button.addEventListener("click", async (e) => {
            const id = e.target.getAttribute("data-id");

            Swal.fire({
                title: "¿Estás seguro dar de baja a este correo?",
                text: "No podrás deshacer esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, confirmar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.post(`/api/emails/discharge/${id}`);
                        location.reload();
                    } catch (error) {
                        window.toast.fire({
                            icon: "error",
                            title:
                                error.response.data ??
                                "Error al enviar el formulario",
                        });
                    }
                }
            });
        });
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
