import axios from "axios";
import ExcelJS from "exceljs";
import moment from "moment";

document.addEventListener("DOMContentLoaded", function () {
    $ = document.querySelector.bind(document);
    const CreateButton = $("#create-eda");
    const CloseButton = $("#close-eda");
    const $formExport = $("#form-export-edas");
    const $exportButton = $("#button-export-edas");

    CreateButton?.addEventListener("click", async () => {
        // disable the button
        CreateButton.disabled = true;
        const id_user = CreateButton.getAttribute("data-id-user");
        const id_year = CreateButton.getAttribute("data-id-year");

        try {
            await axios.post("/api/edas", {
                id_user,
                id_year,
            });

            // reload the page
            location.reload();
        } catch (error) {
            window.toast.fire({
                icon: "error",
                title:
                    error.response.data ??
                    "Ocurrió un error al intentar crear el EDA",
            });
        }
    });

    CloseButton?.addEventListener("click", () => {
        CloseButton.disabled = true;

        const id_eda = CloseButton.getAttribute("data-id");

        Swal.fire({
            title: "¿Estas seguro de cerrar el EDA?",
            text: "No podras deshacer esta acción",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: `Sí, cerrar`,
            cancelButtonText: "Cancelar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    await axios.post(`/api/edas/close/${id_eda}`);
                    // reload the page
                    location.reload();
                } catch (error) {
                    window.toast.fire({
                        icon: "error",
                        title:
                            error.response.data ??
                            "Ocurrió un error al intentar cerrar el EDA",
                    });
                }
            }
        });
    });

    $exportButton?.addEventListener("click", async () => {
        $exportButton.disabled = true;
        $exportButton.classList.add("animation-pulse");
        $exportButton.querySelector("span").innerText = "Exportando...";

        const url = new URL(window.location.href);
        const searchParams = url.searchParams;
        searchParams.set("type", "basic");

        const edas = await window.query(
            `/api/edas/export?${searchParams.toString()}`
        );

        const workbook = new ExcelJS.Workbook();
        const response = await fetch("/templates/basic_edas.xlsx");
        const arrayBuffer = await response.arrayBuffer();

        if (!arrayBuffer) return;

        await workbook.xlsx.load(arrayBuffer);
        const worksheet = workbook.getWorksheet("Edas");
        const startRow = 5;

        edas.forEach((eda, i) => {
            const row = worksheet.getRow(startRow + i);
            const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
            row.getCell(2).value = index;
            row.getCell(3).value = eda.year;
            row.getCell(4).value = eda.full_name;
            row.getCell(5).value = eda.role;
            row.getCell(6).value = eda.job_position;

            // GOALS
            row.getCell(7).value = eda.goals.count;
            row.getCell(8).value = eda.goals.sent
                ? moment(eda.goals.sent).format("DD/MM/YYYY")
                : "-";
            row.getCell(9).value = eda.goals.approved
                ? moment(eda.goals.approved).format("DD/MM/YYYY")
                : "-";

            // EVALUATION 01
            row.getCell(10).value =
                eda.evaluations["1"].self_qualification ?? "-";
            row.getCell(11).value = eda.evaluations["1"].qualification ?? "-";
            row.getCell(12).value = eda.evaluations["1"].closed
                ? moment(eda.evaluations["1"].closed).format("DD/MM/YYYY")
                : "-";
            row.getCell(13).value = eda.evaluations["1"].feedback
                ? moment(eda.evaluations["1"].feedback).format("DD/MM/YYYY")
                : "-";

            // EVALUATION 02
            row.getCell(14).value =
                eda.evaluations["2"].self_qualification ?? "-";
            row.getCell(15).value = eda.evaluations["2"].qualification ?? "-";
            row.getCell(16).value = eda.evaluations["2"].closed
                ? moment(eda.evaluations["2"].closed).format("DD/MM/YYYY")
                : "-";
            row.getCell(17).value = eda.evaluations["2"].feedback
                ? moment(eda.evaluations["2"].feedback).format("DD/MM/YYYY")
                : "-";

            row.getCell(18).value = eda.questionnaires.collaborator.resolved
                ? moment(eda.questionnaires.collaborator.resolved).format(
                      "DD/MM/YYYY"
                  )
                : "-";
            row.getCell(19).value = eda.questionnaires.supervisor.resolved
                ? moment(eda.questionnaires.supervisor.resolved).format(
                      "DD/MM/YYYY"
                  )
                : "-";

            row.getCell(20).value = eda.closed
                ? moment(eda.closed).format("DD/MM/YYYY")
                : "-";

            row.commit();
        });

        worksheet.columns.forEach((column) => {
            let maxLength = 0;
            column.eachCell({ includeEmpty: true }, (cell) => {
                const cellValue = cell.value ? cell.value.toString() : "";
                maxLength = Math.max(maxLength, cellValue.length);
            });
            column.width = maxLength < 10 ? 10 : maxLength + 2;
        });

        const filename = `EDAs_${moment().format("YYYY-MM-DD_HH-mm")}`;

        const buffer = await workbook.xlsx.writeBuffer();

        const blob = new Blob([buffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = filename + ".xlsx";
        link.click();

        $exportButton.disabled = false;
        $exportButton.classList.remove("animation-pulse");
        $exportButton.querySelector("span").innerText = "Exportar";
    });
});
