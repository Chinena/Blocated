//Ejemplo de tabla 2
document.addEventListener("DOMContentLoaded", function() {
    const data = [
    { dia: 'fecha', cantidad: 1 },
    { dia: 'fecha', cantidad: 1 },
    { dia: 'fecha', cantidad: 1 },
    { dia: 'fecha', cantidad: 1 }
];

let tableBody = document.getElementById('tbody2');

for (let i = 0; i < data.length; i++) {
    let dia = `<td>${data[i].dia}</td>`;
    let cantidad = `<td>${data[i].cantidad} recargas</td>`;

    tableBody.innerHTML += `<tr>${dia + cantidad}</tr>`;
}
});