document.addEventListener('DOMContentLoaded', function () {
    // Obtén el nombre del archivo actual
    var currentPage = window.location.pathname.split('/').pop();
    console.log(currentPage);

    // Marca el enlace correspondiente como activo
    var enlace = document.querySelector(`nav a[href="${currentPage}"]`);
    if (enlace) {
        enlace.classList.add('active');
    }
  });

/*
function mostrarSeccion(seccionId) {
    // Oculta todas las secciones
    /*document.querySelectorAll('section').forEach(function(seccion) {
      seccion.style.display = 'none';
    });
  
    // Muestra la sección correspondiente
    document.getElementById(seccionId).style.display = 'block';--/

    // Marca el enlace como activo
    document.querySelectorAll('nav a').forEach(function(enlace) {
        enlace.classList.remove('active');
    });

    document.querySelector(`nav a[href="#${seccionId}"]`).classList.add('active');

}*/

/*window.onload = function () {
    const hash = window.location.hash.substring(1);
    if (hash) {
        mostrarSeccion(hash);
    }
}*/
