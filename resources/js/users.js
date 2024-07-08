const regexDni = /^[0-9]{8}$/;
const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
const usernameRegex = /^[a-zA-Z0-9._-]{4,20}$/;

const capitalize = (str) =>
    str
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");

document.addEventListener("DOMContentLoaded", function () {
    const URL_SUNAT = "https://apisunat.daustinn.com";

    $ = document.querySelector.bind(document);

    const UserForm = $("#user-form");
    const InputDni = $("#dni-input");
    const InputFirstName = $("#first_name-input");
    const InputLastName = $("#last_name-input");
    const JobPositionSelect = $("#job-position-select");
    const RoleSelect = $("#role-select");
    const ButtonSubmit = $("#create-user-button-submit");

    const searchSupervisor = $("#search-supervisor");
    const listUsers = $("#list-users");

    const inputProfile = $("#input-profile");
    const previewProfile = $("#preview-profile");

    const dischargeEmailButtons = document.querySelectorAll(".discharge-email");

    // SET PROFILE
    inputProfile?.addEventListener("change", (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            previewProfile.src = reader.result;
        };
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
        const username = form.get("username");
        const domain = form.get("domain");
        const email = `${username?.trim()}@${domain?.trim()}`;
        form.set("email", email);

        const privileges = Array.from(
            UserForm.querySelectorAll('input[name="privileges[]"]:checked')
        ).map((input) => input.value);

        form.set("privileges", JSON.stringify(privileges));

        // get data-id from search-supervisor
        const supervisorId = searchSupervisor?.getAttribute("data-id");
        if (supervisorId) form.set("supervisor", supervisorId);

        // validate dni
        if (!regexDni.test(dni)) {
            return window.toast.fire({
                icon: "error",
                title: "El DNI debe tener 8 caracteres",
            });
        }

        // validate username
        if (!regexEmail.test(email) && !form.get("id")) {
            return window.toast.fire({
                icon: "error",
                title: "El correo electrónico no es válido",
            });
        }

        ButtonSubmit.disabled = true;

        // image
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
            }
        }

        const fetchurl = form.get("id")
            ? `/api/users/${form.get("id")}`
            : "/api/users";

        // fetch api
        try {
            console.log(Object.fromEntries(form));
            await axios.post(fetchurl, Object.fromEntries(form));
            window.location.href = "/users";
        } catch (error) {
            window.toast.fire({
                icon: "error",
                title: error.response.data ?? "Error al Actualizar el usuario",
            });
        } finally {
            ButtonSubmit.disabled = false;
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
});
