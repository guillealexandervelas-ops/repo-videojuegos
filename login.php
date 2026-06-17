<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <h1>Control de Acceso al Catálogo</h1>
    <a href="index.php" class="volver-btn">Volver al catálogo</a>

    <form action="procesar_login.php" method="POST" class="form">
        <label>Usuario:</label>
        <input type="text" name="username" required placeholder="Ej: admin">

        <label>Contraseña:</label>
        <div class="password-container">
            <input type="password" name="password" required placeholder="******">
            <button type="button" class="toggle-password" aria-label="Mostrar contraseña">
                <i class="bi bi-eye"></i>
            </button>
        </div>

        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
<script src="script.js"></script>
</html>