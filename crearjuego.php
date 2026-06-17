<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Videojuego</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Añadir un Nuevo Videojuego al Catálogo</h1>
    <a href="index.php" class="volver-btn">← Volver al catálogo</a>

    <?php
    require_once 'clases/conexion.php';
    
    $conexion = new Conexion();
    $conexionPDO = $conexion->getConexion();
    
    $generos = [];
    $plataformas = [];
    
    if ($conexionPDO) {
        $stmtGeneros = $conexionPDO->prepare("SELECT id, nombre FROM generos");
        $stmtGeneros->execute();
        $generos = $stmtGeneros->fetchAll(PDO::FETCH_ASSOC);
        
        $stmtPlataformas = $conexionPDO->prepare("SELECT id, nombre FROM plataformas");
        $stmtPlataformas->execute();
        $plataformas = $stmtPlataformas->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <form action="procesar_videojuego.php" method="POST">
        
        <label>Título:</label>
        <input type="text" name="titulo" required>

        <label>Desarrolladora:</label>
        <input type="text" name="desarrolladora" required>

        <label>Año de Lanzamiento:</label>
        <input type="number" name="ano_lanzamiento" min="1950" max="2026" required>

        <label>Género:</label>
        <select name="genero_id" required>
            <option value="">-- Selecciona un género --</option>
            <?php foreach ($generos as $genero): ?>
                <option value="<?php echo $genero['id']; ?>">
                    <?php echo htmlspecialchars($genero['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Plataforma:</label>
        <select name="plataforma_id" required>
            <option value="">-- Selecciona una plataforma --</option>
            <?php foreach ($plataformas as $plataforma): ?>
                <option value="<?php echo $plataforma['id']; ?>">
                    <?php echo htmlspecialchars($plataforma['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock (Unidades):</label>
        <input type="number" name="stock" required>

        <button type="submit">Guardar Videojuego</button>
    </form>
</body>
</html>