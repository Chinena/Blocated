const fecha = new Date();

// Días de la semana
const diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
const diaSemana = diasSemana[fecha.getDay()];

// Meses
const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
const mes = meses[fecha.getMonth()];

const dia = fecha.getDate();
const año = fecha.getFullYear();

// Imprimir fecha en pantalla
const fechaActual = `${diaSemana}, ${dia} de ${mes} de ${año}`; 
document.getElementById("fecha").textContent = fechaActual;
