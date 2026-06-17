<?php
session_start();

// 1. Candado de seguridad obligatorio
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/dlc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Recoger los datos enviados por el formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $juego_base_id = $_POST['juego_base_id'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // 3. Crear el objeto DLC con los nuevos datos (pasándole su ID)
    $dlcEditado = new DLC(
        $id,
        $titulo,
        'DLC',
        $precio,
        $stock,
        $juego_base_id,
        $descripcion
    );

    // 4. Conectar a la base de datos y lanzar la actualización
    $conexionObj = new Conexion();
    $conexionPDO = $conexionObj->getConexion();
    $repositorio = new Repositorio($conexionPDO);

    if ($repositorio->actualizarDLC($dlcEditado)) {
        // Si todo ha ido bien, volvemos al catálogo principal
        header('Location: index.php');
        exit();
    } else {
        echo "Error al intentar actualizar el DLC en la base de datos. <a href='index.php'>Volver</a>";
    }
} else {
    echo "Acceso inválido. <a href='index.php'>Volver</a>";
}
?>
