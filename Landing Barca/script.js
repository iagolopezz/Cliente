document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('barcaForm');
    const successMessage = document.getElementById('successMessage');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        let isValid = true;

        // Validar Nombre
        const nombre = document.getElementById('nombre');
        const errorNombre = document.getElementById('error-nombre');
        if (nombre.value.trim() === '') {
            nombre.parentElement.classList.add('invalid');
            isValid = false;
        } else {
            nombre.parentElement.classList.remove('invalid');
        }

        // Validar Email
        const email = document.getElementById('email');
        const errorEmail = document.getElementById('error-email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            email.parentElement.classList.add('invalid');
            isValid = false;
        } else {
            email.parentElement.classList.remove('invalid');
        }

        // Validar País
        const pais = document.getElementById('pais');
        const errorPais = document.getElementById('error-pais');
        if (pais.value === '') {
            pais.parentElement.classList.add('invalid');
            isValid = false;
        } else {
            pais.parentElement.classList.remove('invalid');
        }

        // Validar Términos
        const terminos = document.getElementById('terminos');
        const errorTerminos = document.getElementById('error-terminos');
        if (!terminos.checked) {
            errorTerminos.style.display = 'block';
            isValid = false;
        } else {
            errorTerminos.style.display = 'none';
        }

        // Si todo es válido, mostrar animación de éxito
        if (isValid) {
            successMessage.classList.add('active');
            form.reset();
        }
    });

    // Limpiar errores mientras el usuario escribe o interactúa
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (input.type !== 'checkbox') {
                if (input.value.trim() !== '') {
                    input.parentElement.classList.remove('invalid');
                }
            } else {
                if (input.checked) {
                    document.getElementById('error-terminos').style.display = 'none';
                }
            }
        });
        
        input.addEventListener('change', () => {
            if (input.tagName === 'SELECT' && input.value !== '') {
                input.parentElement.classList.remove('invalid');
            }
        });
    });
});
