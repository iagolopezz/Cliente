$(document).ready(function() {

    // === 1. CAPTURA DE DATOS (INDEX) ===
$('#form-registro').on('submit', function() {
    // Al quitar 'e.preventDefault()', permitimos que el 'action' del HTML cambie de página,
    // pero justo antes de irse, forzamos el guardado en la memoria:
    localStorage.setItem('culé_nombre', $('#nombre').val());
    localStorage.setItem('culé_email', $('#email').val());
    localStorage.setItem('culé_pais', $('#pais').val());
});

    // === 2. MUESTRA DE DATOS (RESULTADO) ===
    // Si estamos en la página de resultados, extraemos y pintamos los datos
    if ($('#res-nombre').length || window.location.pathname.includes('resultado.html')) {
        
        // Buscamos lo guardado en la memoria local (si no hay nada, ponemos un texto de ayuda)
        const nombreGuardado = localStorage.getItem('culé_nombre') || 'Aficionado';
        const emailGuardado = localStorage.getItem('culé_email') || 'No proporcionado';
        const paisGuardado = localStorage.getItem('culé_pais') || 'No especificado';

        // Inyectamos los textos en las etiquetas correspondientes de resultado.html
        $('#res-nombre').text(nombreGuardado);
        $('#res-email').text(emailGuardado);
        $('#res-pais').text(paisGuardado);
    }
});
