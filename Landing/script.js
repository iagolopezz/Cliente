document.getElementById('barcaForm').addEventListener('submit', function(evento) {
    // Evitamos que la página se recargue al enviar
    evento.preventDefault();

    // Capturamos los valores que escribió el usuario
    const valorNombre = document.getElementById('nombre').value;
    const valorEmail = document.getElementById('email').value;
    const valorPais = document.getElementById('pais').value;

    // Seleccionamos el lugar donde queremos mostrar los resultados
    const contenedorRespuestas = document.getElementById('respuestas-usuario');

    // Metemos las respuestas dentro de una cajita con estructura HTML sencilla
    contenedorRespuestas.innerHTML = `
        <div class="caja-respuestas">
            <p><strong>Nombre:</strong> ${valorNombre}</p>
            <p><strong>Email:</strong> ${valorEmail}</p>
            <p><strong>País:</strong> ${valorPais}</p>
        </div>
    `;

    // 5. Ocultamos el formulario y mostramos la sección de éxito
    document.getElementById('barcaForm').style.display = 'none';
    document.getElementById('successMessage').style.display = 'block';
});
