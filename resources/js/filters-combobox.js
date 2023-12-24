// document.addEventListener("DOMContentLoaded", function () {

//     function handleSelectChange(selectId, paramName) {
//         var selectedValue = document.getElementById(selectId).value;
//         var currentURL = window.location.href;
//         var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
//         if (regex.test(currentURL)) {
//             currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
//                 selectedValue + '$2');
//         } else {
//             currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
//         }
//         window.location.href = currentURL;
//     }

//     document.getElementById('cargo').addEventListener('change', function () {
//         handleSelectChange('cargo', 'cargo');
//     });
//     document.getElementById('puesto').addEventListener('change', function () {
//         handleSelectChange('puesto', 'puesto');
//     });
//     document.getElementById('departamento').addEventListener('change', function () {
//         handleSelectChange('departamento', 'departamento');
//     });
//     document.getElementById('area').addEventListener('change', function () {
//         handleSelectChange('area', 'area');
//     });
//     document.getElementById('estado').addEventListener('change', function () {
//         handleSelectChange('estado', 'estado');
//     });
// })