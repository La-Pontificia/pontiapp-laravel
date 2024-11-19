import axios from "axios";

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

    const $userForm = $("#create-user-form");
    const InputDni = $("#dni-input");
    const InputFirstName = $("#first_name-input");
    const InputLastName = $("#last_name-input");
    const JobPositionSelect = $("#job-position-select");
    const RoleSelect = $("#role-select");

    const $inputProfile = $("#input-profile");
    const previewProfile = $("#preview-profile");

    // SET PROFILE
    $inputProfile?.addEventListener("change", async (e) => {
        const file = e.target.files[0];
        const isUpdated = $inputProfile.getAttribute("data-userid");
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            previewProfile.src = reader.result;
        };
        $inputProfile.setAttribute("data-fill", true);

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
                const id = $inputProfile.getAttribute("data-userid");

                await axios.post(`/api/users/${id}/profile`, { profile: uri });

                window.location.reload();
            } catch (error) {
                console.error(error);
                alert("Error al subir la imagen");
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
                option.textContent = `${role.name}`;
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
    $userForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);

        window.disabledFormChildren($userForm);

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

                const uri = res.data.secure_url;
            } catch (error) {
                console.error(error);
            }
        }

        try {
            const formData = new FormData($userForm);
            const { data } = await axios.post("/api/users", formData);
            window.location.href = `/users/${data.id}`;
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                confirmButtonColor: "#d33",
                text: error.response.data ?? "Error al registrar el usuario",
            });
        } finally {
            window.enabledFormChildren($userForm);
        }
    });

    // change password
    const formChangePassword = $("#form-change-password");
    formChangePassword?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const action = formChangePassword.getAttribute("action");

        const new_password = formData.get("new_password");
        const new_password_confirmation = formData.get(
            "new_password_confirmation"
        );

        if (new_password.length < 8) {
            return window.alert(
                "Hey...",
                "La contraseña debe tener al menos 8 caracteres"
            );
        }

        if (new_password !== new_password_confirmation) {
            return window.alert("Hey...", "Las contraseñas no coinciden");
        }

        window.disabledFormChildren(formChangePassword);

        await window.mutation(action, Object.fromEntries(formData));

        window.enabledFormChildren(formChangePassword);
    });

    // add schedule in user form
    const $formSchedule = $("#schedule-form-create-user");
    const $schedulesUser = $("#schedules-user");
    const $scheduleUserItem = $("#schedule-user-item");
    $formSchedule?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);

        const days = {
            1: "Lunes",
            2: "Martes",
            3: "Miércoles",
            4: "Jueves",
            5: "Viernes",
            6: "Sábado",
            7: "Domingo",
        };

        const start_date = form.get("start_date");
        const from = form.get("from");
        const to = form.get("to");
        const terminal = form.get("terminal");

        const $terminalSelect = $formSchedule.querySelector(".terminal-select");
        const $timesSelect = $formSchedule.querySelector(".times-select");

        const $times = Array.from(
            $timesSelect.querySelectorAll("option")
        ).reduce((acc, option) => {
            acc[option.value] = option.textContent.trim();
            return acc;
        }, {});

        const terminals = Array.from(
            $terminalSelect.querySelectorAll("option")
        ).reduce((acc, option) => {
            acc[option.value] = option.textContent.trim();
            return acc;
        }, {});

        const name = "schedule[]";
        const dayValue = form.getAll("day[]");
        const dayNames = dayValue.map((day) => days[day]).join(", ");
        const value = JSON.stringify({
            days: dayValue,
            start_date,
            from,
            to,
            terminal_id: terminal,
        });
        const terminalName = terminals[terminal];

        const $item = document.importNode(
            $scheduleUserItem.content,
            true
        ).firstElementChild;

        $item.querySelector(
            "h2"
        ).textContent = `${$times[from]} - ${$times[to]} (${terminalName})`;
        $item.querySelector("p").textContent = dayNames;
        $item.querySelector("input").setAttribute("name", name);
        $item.querySelector("input").setAttribute("value", value);
        $item.querySelector("input").setAttribute("form", "form-user");
        const $appendedItem = $schedulesUser.appendChild($item);
        $appendedItem.querySelector("button").addEventListener("click", (e) => {
            e.preventDefault();
            $appendedItem.remove();
        });

        $('[data-modal-hide="dialog"]')?.click();
    });
});
