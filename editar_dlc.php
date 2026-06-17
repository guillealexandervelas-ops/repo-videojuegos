<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/dlc.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de DLC no especificado. <a href='index.php'>Volver</a>";
    exit();
}

$id = $_GET['id'];

$conexionObj = new Conexion();
$conexionPDO = $conexionObj->getConexion();
$repositorio = new Repositorio($conexionPDO);

$dlc = $repositorio->obtenerDLCPorId($id);

if ($dlc === null) {
    echo "El DLC no existe. <a href='index.php'>Volver</a>";
    exit();
}

$videojuegos = [];
if ($conexionPDO) {
    $stmt = $conexionPDO->prepare("SELECT id, titulo FROM videojuegos ORDER BY titulo");
    $stmt->execute();
    $videojuegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar DLC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar DLC: <?php echo htmlspecialchars($dlc->getTitulo()); ?></h1>
    <a href="index.php" class="volver-btn">← Volver al catálogo</a>

    <form action="procesar_editar_dlc.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $dlc->getId(); ?>">

        <label>Título:</label>
        <input type="text" name="titulo" required value="<?php echo htmlspecialchars($dlc->getTitulo()); ?>">

        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($dlc->getDescripcion()); ?></textarea>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" required value="<?php echo $dlc->getPrecio(); ?>">

        <label>Stock:</label>
        <input type="number" name="stock" required value="<?php echo $dlc->getStock(); ?>">

        <label>Juego Base:</label>
        <select name="juego_base_id" required>
            <option value="">-- Selecciona un juego --</option>
            <?php foreach ($videojuegos as $juego): ?>
                <option value="<?php echo $juego['id']; ?>" <?php echo ($dlc->getJuegoBaseId() == $juego['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($juego['titulo']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
