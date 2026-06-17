<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $conexionObj = new Conexion();
    $conexionPDO = $conexionObj->getConexion();
    $repositorio = new Repositorio($conexionPDO);

    if ($repositorio->eliminarDLC((int)$_POST['id'])) {
        header('Location: index.php');
        exit();
    }
}

echo "No se pudo borrar el DLC. <a href='index.php'>Volver</a>";
?>