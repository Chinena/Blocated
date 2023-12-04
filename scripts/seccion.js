/*function mostrarSeccion(seccionId) {
    // Ocultar todas las secciones
    const secciones = document.querySelectorAll('section');
    secciones.forEach(seccion => {
        seccion.classList.add('hidden');
    });

    // Mostrar la sección seleccionada
    const seccion = document.getElementById(seccionId);
    if (seccion) {
        seccion.classList.remove('hidden');
    }
}

// Esto permite ocultar todas las secciones al relogear la pagina o entrar por primera vez
window.onload = function () {
    const hash = window.location.hash.substring(1);
    if (hash) {
        mostrarSeccion(hash);
    }
}*/

function mostrarSeccion(seccionId) {
    // Oculta todas las secciones
    document.querySelectorAll('section').forEach(function(seccion) {
      seccion.style.display = 'none';
    });
  
    // Muestra la sección correspondiente
    document.getElementById(seccionId).style.display = 'block';

}

window.onload = function () {
    const hash = window.location.hash.substring(1);
    if (hash) {
        mostrarSeccion(hash);
    }
}
  