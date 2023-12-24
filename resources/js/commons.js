

const btn = document.getElementById('exportBtn');
const comboboxs = document.querySelectorAll('.combobox-dinamic');

if (comboboxs) {
    comboboxs.forEach(combobox => {
        combobox.addEventListener('change', (event) => {
            const name = combobox.getAttribute('name');
            const value = event.target.value;
            handleSelectChange(value, name);
        });
    })
}

if (btn) {
    btn.addEventListener('click', (ev) => {
        const name = ev.target.getAttribute('name');
        const dataUrl = ev.target.getAttribute('data-url');
        exportarExcel(dataUrl, name);
    });
}

// -----------------EXPORT EXCELS
async function exportarExcel(url, nombre) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'json');
    const res = await axios.get(`${url}?` + params.toString());
    if (res.data.length > 0) {
        var workbook = new ExcelJS.Workbook();
        var worksheet = workbook.addWorksheet('Hoja1');
        var headers = Object.keys(res.data[0]);
        var headerRow = worksheet.addRow(headers);
        headerRow.eachCell(cell => {
            cell.font = {
                bold: true
            };
            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: 'FFFF00'
                }
            };
        });

        res.data.forEach(item => {
            var rowData = headers.map(header => item[header]);
            worksheet.addRow(rowData);
        });

        worksheet.columns.forEach(column => {
            var maxLength = 0;
            column.eachCell({
                includeEmpty: true
            }, cell => {
                const columnLength = cell.value ? cell.value.toString().length : 10;
                maxLength = Math.max(maxLength, columnLength);
            });
            column.width = maxLength < 10 ? 10 : maxLength; // Establece un ancho mínimo
        });

        workbook.xlsx.writeBuffer().then(function (buffer) {
            var blob = new Blob([buffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = `${new Date().toLocaleDateString()}-${nombre}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    } else {
        console.error('La respuesta de la API no contiene datos.');
    }
}


// -----------------DINAMIC COMBOBOX
function handleSelectChange(selectedValue, paramName) {
    var currentURL = window.location.href;
    currentURL = currentURL.replace(/[?&]page(=([^&#]*)|&|#|$)/, '');
    var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
    if (regex.test(currentURL)) {
        currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
            selectedValue + '$2');
    } else {
        currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
    }
    window.location.href = currentURL;
}
