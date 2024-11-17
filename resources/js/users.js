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
});
