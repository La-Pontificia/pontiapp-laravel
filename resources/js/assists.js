import ExcelJS from "exceljs";
import moment from "moment";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const $perSchedule = $("#button-export-assists-per-schedule");

    async function exportAssists(groupAssists) {
        const workbook = new ExcelJS.Workbook();
        const response = await fetch("/templates/assists.xlsx");
        const arrayBuffer = await response.arrayBuffer();

        if (!arrayBuffer) return;

        await workbook.xlsx.load(arrayBuffer);
        const worksheet = workbook.getWorksheet("Asistencias");

        let rr = 4;

        groupAssists.forEach((item, i) => {
            item.assists.forEach((assist, ii) => {
                const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
                const row = worksheet.getRow(rr);
                rr++;
                row.getCell(2).value = ii === 0 ? index : "";
                row.getCell(3).value = ii === 0 ? item.dni : "";
                row.getCell(4).value = ii === 0 ? item.full_name : "";
                row.getCell(5).value = assist.role?.name;
                row.getCell(6).value = assist.job_position?.name;
                row.getCell(7).value = assist.title;
                row.getCell(8).value = assist.date;
                row.getCell(9).value = assist.day;
                row.getCell(10).value = assist.turn;
                row.getCell(11).value = assist.from;
                row.getCell(12).value = assist.to;
                row.getCell(13).value = assist.marked_in;
                row.getCell(14).value = assist.marked_out;
                row.getCell(15).value = assist.difference;
                row.getCell(16).value = assist.terminal;
                row.getCell(17).value = assist.observations;
            });
        });

        worksheet.columns.forEach((column) => {
            let maxLength = 0;
            column.eachCell({ includeEmpty: true }, (cell) => {
                const cellValue = cell.value ? cell.value.toString() : "";
                maxLength = Math.max(maxLength, cellValue.length);
            });
            column.width = maxLength < 10 ? 10 : maxLength + 2;
        });

        const filename = `Asistencias_${moment().format("YYYY-MM-DD")}`;

        const buffer = await workbook.xlsx.writeBuffer();

        const blob = new Blob([buffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = filename + ".xlsx";
        link.click();
    }

    if ($perSchedule) {
        $perSchedule.onclick = async () => {
            $perSchedule.disabled = true;
            $perSchedule.classList.add("animation-pulse");
            $perSchedule.querySelector("span").innerText = "Espere...";

            try {
                const url = new URL(window.location.href);
                const searchParams = url.searchParams;

                const assists = await window.query(
                    `/api/assists/export?${searchParams.toString()}`
                );

                const groupAssists = assists.reduce((acc, item) => {
                    const { dni, full_name, ...rest } = item;
                    const index = acc.findIndex((i) => i.dni === dni);
                    if (index === -1)
                        acc.push({ dni, full_name, assists: [rest] });
                    else acc[index].assists.push(item);
                    return acc;
                }, []);

                console.log(groupAssists);

                await exportAssists(groupAssists);
            } catch (error) {
                console.error(error);
                window.alert(
                    "Error",
                    "Ocurrió un error al exportar las asistencias"
                );
            } finally {
                $perSchedule.disabled = false;
                $perSchedule.classList.remove("animation-pulse");
                $perSchedule.querySelector("span").innerText = "Exportar";
            }
        };
    }

    // $exportButtons?.forEach(($exportButton) => {

    //     const url = new URL(window.location.href);
    //     const searchParams = url.searchParams;

    //     const edas = await window.query(
    //         `/api/users/export?${searchParams.toString()}`
    //     );

    //     $exportButton?.addEventListener("click", async () => {
    //         const table = $("#table-export-assists");
    //         const tbody = table.querySelector("tbody");
    //         const rows = tbody.querySelectorAll("tr");
    //         const attendances = [];

    //         $exportButton.disabled = true;

    //         rows.forEach((row) => {
    //             const columns = row.querySelectorAll("td");
    //             const ariahidden = row.getAttribute("aria-hidden");
    //             const dni = row.getAttribute("data-dni");
    //             const full_name = row.getAttribute("data-fullnames");
    //             if (ariahidden === "true") return;

    //             let item = {};
    //             columns.forEach((column) => {
    //                 const value = column.getAttribute("data-value");
    //                 const name = column.getAttribute("data-name");
    //                 item = { ...item, [name]: value };
    //             });
    //             attendances.push({ ...item, dni, full_name });
    //         });

    //         const groupAssistances = attendances.reduce((acc, item) => {
    //             const { dni, full_name, ...rest } = item;
    //             const index = acc.findIndex((i) => i.dni === dni);
    //             if (index === -1) {
    //                 acc.push({ dni, full_name, assistances: [rest] });
    //             } else {
    //                 acc[index].assistances.push(item);
    //             }
    //             return acc;
    //         }, []);

    //         const type = $exportButton.getAttribute("data-type");

    //         const dateRange = $("#date-range");
    //         const start = dateRange.querySelector("input[name=start]");
    //         const end = dateRange.querySelector("input[name=end]");

    //         const filename = `Asistencias ${start.value} - ${end.value}`;

    //         if (type === "excel") {
    //             const workbook = new ExcelJS.Workbook();
    //             const worksheet = workbook.addWorksheet("Asistencias");

    //             worksheet.columns = [
    //                 { header: "N°", key: "index" },
    //                 { header: "DNI", key: "dni" },
    //                 { header: "Nombres y Apellidos", key: "full_name" },
    //                 { header: "Título", key: "title" },
    //                 { header: "Fecha", key: "date" },
    //                 { header: "Dia", key: "day" },
    //                 { header: "Turno", key: "turn" },
    //                 { header: "Entrada", key: "from" },
    //                 { header: "Salida", key: "to" },
    //                 { header: "Entró", key: "marked_in" },
    //                 { header: "Salió", key: "marked_out" },
    //                 { header: "Diferencia", key: "difference" },
    //                 { header: "Terminal", key: "terminal" },
    //                 { header: "Observaciones", key: "observations" },
    //             ];

    //             groupAssistances.forEach((item) => {
    //                 worksheet.addRow({});
    //                 item.assistances.forEach((assist, i) => {
    //                     const index = i + 1 < 10 ? `0${i + 1}` : i + 1;
    //                     const row = worksheet.addRow({
    //                         index,
    //                         dni: item.dni,
    //                         full_name: item.full_name,
    //                         ...assist,
    //                     });
    //                     row.getCell("index").alignment = { horizontal: "left" };
    //                 });
    //             });

    //             worksheet.columns.forEach((column) => {
    //                 let maxLength = 0;
    //                 column.eachCell({ includeEmpty: true }, (cell) => {
    //                     const cellValue = cell.value
    //                         ? cell.value.toString()
    //                         : "";
    //                     maxLength = Math.max(maxLength, cellValue.length);
    //                 });
    //                 column.width = maxLength < 10 ? 10 : maxLength + 2;
    //             });

    //             workbook.xlsx.writeBuffer().then((buffer) => {
    //                 const blob = new Blob([buffer], {
    //                     type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    //                 });
    //                 const link = document.createElement("a");
    //                 link.href = URL.createObjectURL(blob);
    //                 link.download = filename + ".xlsx";
    //                 link.click();
    //             });
    //         } else if (type === "json") {
    //             const blob = new Blob([JSON.stringify(groupAssistances)], {
    //                 type: "application/json",
    //             });
    //             const link = document.createElement("a");
    //             link.href = URL.createObjectURL(blob);
    //             link.download = filename + ".json";
    //             link.click();
    //         }

    //         $exportButton.disabled = false;
    //     });
    // });
});
