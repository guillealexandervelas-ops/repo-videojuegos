    // Mostrar/Ocultar contraseña
    document.querySelectorAllog('.tgle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('i');
            const isPassword = input.type === 'password';
            
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            btn.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    });
