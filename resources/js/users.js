import axios from "axios";
import ExcelJS from "exceljs";
import moment from "moment";

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

                            await window.mutation(
                                `/api/users/supervisor/assign/${id}`,
                                {
                                    supervisor_id: user.id,
                                }
                            );

                            clone.disabled = false;
                        });

                    resultContainer.appendChild(clone);
                });
            }, 300)
        );
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

    // export data users

    const exportButton = $("#export-data-users");

    exportButton?.addEventListener("click", async () => {
        const url = new URL(window.location.href);
        const searchParams = url.searchParams;
        const uri = `/api/users/export?${searchParams.toString()}`;
        try {
            const { data: users } = await axios.get(uri);

            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet("Usuarios");

            worksheet.columns = [
                { header: "N°", key: "index" },
                { header: "DNI", key: "dni" },
                { header: "Apellidos", key: "last_name" },
                { header: "Nombres", key: "first_name" },
                { header: "Correo", key: "email" },
                { header: "Area", key: "area" },
                { header: "Departamento", key: "department" },
                { header: "Puesto", key: "job_position" },
                { header: "Cargo", key: "role_position" },
                { header: "Supervisor", key: "supervisor" },
                { header: "Perfil", key: "profile" },
                { header: "Rol", key: "role" },
                { header: "Estado", key: "status" },
                { header: "Sede", key: "branch" },
                { header: "Grupo de Horario", key: "schedule" },
                { header: "Fecha de creación", key: "created_at" },
                { header: "Fecha de actualización", key: "updated_at" },
                { header: "Creado por", key: "created_by" },
                { header: "Actualizado por", key: "updated_by" },
            ];

            users.forEach((user, i) => {
                const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
                const row = worksheet.addRow({
                    index,
                    dni: user.dni,
                    last_name: user.last_name,
                    first_name: user.first_name,
                    email: user.email,
                    area: user.role_position.department.area.name,
                    department: user.role_position.department.name,
                    job_position: user.role_position.job_position.name,
                    role_position: user.role_position.name,
                    supervisor: user.supervisor
                        ? `${user.supervisor.last_name}, ${user.supervisor.first_name}`
                        : "",
                    profile: user.profile,
                    role: user.role.title,
                    status: user.status ? "Activo" : "Inactivo",
                    branch: user.branch.name,
                    schedule: user.schedule?.name,
                    created_at: moment(user.created_at).format(
                        "DD-MM-YYYY HH:mm"
                    ),
                    updated_at: moment(user.updated_at).format(
                        "DD-MM-YYYY HH:mm"
                    ),
                    created_by: `${user.created_by.last_name}, ${user.created_by.first_name}`,
                    updated_by: user.updated_by
                        ? `${user.updated_by.last_name}, ${user.updated_by.first_name}`
                        : "",
                });
                row.getCell("index").alignment = { horizontal: "left" };
            });
            worksheet.columns.forEach((column) => {
                let maxLength = 0;
                column.eachCell({ includeEmpty: true }, (cell) => {
                    const cellValue = cell.value ? cell.value.toString() : "";
                    maxLength = Math.max(maxLength, cellValue.length);
                });
                column.width = maxLength < 10 ? 10 : maxLength + 2;
            });

            const date = moment().format("DD-MM-YYYY");
            const name = `Usuarios-${date}.xlsx`;

            workbook.xlsx.writeBuffer().then((buffer) => {
                const blob = new Blob([buffer], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = name;
                link.click();
            });
        } catch (error) {
            console.error(error);
            window.toast.fire({
                icon: "error",
                title: "Error al exportar los datos",
            });
        }
    });

    const exportEmailAcessButton = $("#export-email-access");

    exportEmailAcessButton?.addEventListener("click", async () => {
        const url = new URL(window.location.href);
        const searchParams = url.searchParams;
        const uri = `/api/users/export-email-access?${searchParams.toString()}`;
        try {
            const { data: users } = await axios.get(uri);

            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet("Usuarios");

            console.log(users);

            // worksheet.columns = [
            //     { header: "N°", key: "index" },
            //     { header: "DNI", key: "dni" },
            //     { header: "Apellidos", key: "last_name" },
            //     { header: "Nombres", key: "first_name" },
            //     { header: "Correo", key: "email" },
            //     { header: "Area", key: "area" },
            //     { header: "Departamento", key: "department" },
            //     { header: "Puesto", key: "job_position" },
            //     { header: "Cargo", key: "role_position" },
            //     { header: "Supervisor", key: "supervisor" },
            //     { header: "Perfil", key: "profile" },
            //     { header: "Rol", key: "role" },
            //     { header: "Estado", key: "status" },
            //     { header: "Sede", key: "branch" },
            //     { header: "Grupo de Horario", key: "schedule" },
            //     { header: "Fecha de creación", key: "created_at" },
            //     { header: "Fecha de actualización", key: "updated_at" },
            //     { header: "Creado por", key: "created_by" },
            //     { header: "Actualizado por", key: "updated_by" },
            // ];

            // users.forEach((user, i) => {
            //     const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
            //     const row = worksheet.addRow({
            //         index,
            //         dni: user.dni,
            //         last_name: user.last_name,
            //         first_name: user.first_name,
            //         email: user.email,
            //         area: user.role_position.department.area.name,
            //         department: user.role_position.department.name,
            //         job_position: user.role_position.job_position.name,
            //         role_position: user.role_position.name,
            //         supervisor: user.supervisor
            //             ? `${user.supervisor.last_name}, ${user.supervisor.first_name}`
            //             : "",
            //         profile: user.profile,
            //         role: user.role.title,
            //         status: user.status ? "Activo" : "Inactivo",
            //         branch: user.branch.name,
            //         schedule: user.schedule?.name,
            //         created_at: moment(user.created_at).format(
            //             "DD-MM-YYYY HH:mm"
            //         ),
            //         updated_at: moment(user.updated_at).format(
            //             "DD-MM-YYYY HH:mm"
            //         ),
            //         created_by: `${user.created_by.last_name}, ${user.created_by.first_name}`,
            //         updated_by: user.updated_by
            //             ? `${user.updated_by.last_name}, ${user.updated_by.first_name}`
            //             : "",
            //     });
            //     row.getCell("index").alignment = { horizontal: "left" };
            // });
            // worksheet.columns.forEach((column) => {
            //     let maxLength = 0;
            //     column.eachCell({ includeEmpty: true }, (cell) => {
            //         const cellValue = cell.value ? cell.value.toString() : "";
            //         maxLength = Math.max(maxLength, cellValue.length);
            //     });
            //     column.width = maxLength < 10 ? 10 : maxLength + 2;
            // });

            // const date = moment().format("DD-MM-YYYY");
            // const name = `Usuarios-${date}.xlsx`;

            // workbook.xlsx.writeBuffer().then((buffer) => {
            //     const blob = new Blob([buffer], {
            //         type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            //     });
            //     const link = document.createElement("a");
            //     link.href = URL.createObjectURL(blob);
            //     link.download = name;
            //     link.click();
            // });
        } catch (error) {
            console.error(error);
            window.toast.fire({
                icon: "error",
                title: "Error al exportar los datos",
            });
        }
    });
});
