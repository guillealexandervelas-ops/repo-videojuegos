<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/videojuego.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de videojuego no especificado. <a href='index.php'>Volver</a>";
    exit();
}

$id = $_GET['id'];

$conexionObj = new Conexion();
$conexionPDO = $conexionObj->getConexion();
$repositorio = new Repositorio($conexionPDO);

$videojuego = $repositorio->obtenerVideojuegoPorId($id);

if ($videojuego === null) {
    echo "El juego no existe. <a href='index.php'>Volver</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Videojuego</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Videojuego: <?php echo htmlspecialchars($videojuego->getTitulo()); ?></h1>
    <a href="index.php" class="volver-btn">Volver al catálogo</a>

    <form action="procesar_editar.php" method="POST">
        
        <input type="hidden" name="id" value="<?php echo $videojuego->getId(); ?>">

        <label>Título:</label>
        <input type="text" name="titulo" required value="<?php echo htmlspecialchars($videojuego->getTitulo()); ?>">

        <label>Desarrolladora:</label>
        <input type="text" name="desarrolladora" required value="<?php echo htmlspecialchars($videojuego->getDesarrolladora()); ?>">

        <label>Año de Lanzamiento:</label>
        <input type="number" name="ano_lanzamiento" required value="<?php echo $videojuego->getAnoLanzamiento(); ?>">

        <label>Precio ($):</label>
        <input type="number" step="0.01" name="precio" required value="<?php echo $videojuego->getPrecio(); ?>">

        <label>Stock:</label>
        <input type="number" name="stock" required value="<?php echo $videojuego->getStock(); ?>">

        <label>ID Plataforma:</label>
        <input type="number" name="plataforma_id" required value="<?php echo $videojuego->getPlataformaId(); ?>">

        <label>ID Género:</label>
        <input type="number" name="genero_id" required value="<?php echo $videojuego->getGeneroId(); ?>">

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>