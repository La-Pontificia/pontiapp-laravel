import ExcelJS from "exceljs";
import moment from "moment";

document.addEventListener("DOMContentLoaded", async () => {
    $ = document.querySelector.bind(document);
    const $perSchedule = $("#button-export-assists-per-schedule");
    const $peerUser = $("#button-export-assists-peer-user");

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
                row.getCell(5).value = assist.role;
                row.getCell(6).value = assist.job_position;
                row.getCell(7).value = assist.title;
                row.getCell(8).value = assist.date;
                row.getCell(9).value = assist.day;
                row.getCell(10).value = assist.turn;
                row.getCell(11).value = moment(assist.from).format("HH:mm");
                row.getCell(12).value = moment(assist.to).format("HH:mm");
                row.getCell(13).value = assist.marked_in;
                row.getCell(14).value = assist.marked_out;
                row.getCell(15).value = assist.owes_time;
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

    if ($peerUser) {
        $peerUser.onclick = async () => {
            $peerUser.disabled = true;
            $peerUser.classList.add("animation-pulse");
            $peerUser.querySelector("span").innerText = "Espere...";
            const id = $peerUser.getAttribute("data-id");

            try {
                const url = new URL(window.location.href);
                const searchParams = url.searchParams;

                const assists = await window.query(
                    `/api/assists/peer-user/${id}/export?${searchParams.toString()}`
                );

                const groupAssists = assists.reverse().reduce((acc, item) => {
                    const { dni, full_name, ...rest } = item;
                    const index = acc.findIndex((i) => i.dni === dni);
                    if (index === -1)
                        acc.push({ dni, full_name, assists: [rest] });
                    else acc[index].assists.push(item);
                    return acc;
                }, []);

                await exportAssists(groupAssists);
            } catch (error) {
                console.error(error);
                window.alert(
                    "Error",
                    "Ocurrió un error al exportar las asistencias"
                );
            } finally {
                $peerUser.disabled = false;
                $peerUser.classList.remove("animation-pulse");
                $peerUser.querySelector("span").innerText = "Exportar";
            }
        };
    }
});
