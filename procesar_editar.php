<?php
session_start();

// 1. Candado de seguridad obligatorio
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/videojuego.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Recoger los datos enviados por el formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $desarrolladora = $_POST['desarrolladora'];
    $ano_lanzamiento = $_POST['ano_lanzamiento'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $plataforma_id = $_POST['plataforma_id'];
    $genero_id = $_POST['genero_id'];

    // 3. Crear el objeto Videojuego con los nuevos datos (pasándole su ID)
    $videojuegoEditado = new Videojuego(
        $id,
        $titulo,
        'Videojuego',
        $precio,
        $stock,
        $plataforma_id,
        $genero_id,
        $desarrolladora,
        $ano_lanzamiento
    );

    // 4. Conectar a la base de datos y lanzar la actualización
    $conexionObj = new Conexion();
    $conexionPDO = $conexionObj->getConexion();
    $repositorio = new Repositorio($conexionPDO);

    if ($repositorio->actualizarVideojuego($videojuegoEditado)) {
        // Si todo ha ido bien, volvemos al catálogo principal
        header('Location: index.php');
        exit();
    } else {
        echo "Error al intentar actualizar el videojuego en la base de datos. <a href='index.php'>Volver</a>";
    }
} else {
    echo "Método de envío no permitido.";
}
?>