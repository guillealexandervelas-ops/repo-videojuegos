<?php
    require_once 'clases/conexion.php';
    
    $conexion = new Conexion();
    $conexionPDO = $conexion->getConexion();
    
    $videojuegos = [];
    
    if ($conexionPDO) {
        $stmtVideojuegos = $conexionPDO->prepare("SELECT id, titulo FROM videojuegos ORDER BY titulo");
        $stmtVideojuegos->execute();
        $videojuegos = $stmtVideojuegos->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo DLC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Añadir un Nuevo DLC al Catálogo</h1>
    <a href="index.php" class="volver-btn">Volver al catálogo</a>
    <form action="procesar_dlc.php" method="POST">
        
        <label>Título del DLC:</label>
        <input type="text" name="titulo" required>

        <label>Juego Base:</label>
        <select name="juego_base_id" required>
            <option value="">-- Selecciona un juego --</option>
            <?php foreach ($videojuegos as $juego): ?>
                <option value="<?php echo $juego['id']; ?>">
                    <?php echo htmlspecialchars($juego['titulo']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Descripción:</label>
        <textarea name="descripcion" rows="4" required></textarea>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock (Unidades):</label>
        <input type="number" name="stock" required>

        <button type="submit">Guardar DLC</button>
    </form>
</body>
</html>
