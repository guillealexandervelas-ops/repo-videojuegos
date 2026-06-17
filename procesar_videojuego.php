<?php
require_once 'clases/repositorio.php';
require_once 'clases/conexion.php';
require_once 'clases/videojuego.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
        $plataforma_id = $_POST['plataforma_id'];
        $desarrolladora = $_POST['desarrolladora'];
    $ano_lanzamiento = $_POST['ano_lanzamiento'];
    $genero_id = $_POST['genero_id']; // Asignar null si no se proporciona

    $videojuego = new Videojuego(
        null, // ID será asignado por la base de datos
        $titulo,
        'Videojuego', // Tipo fijo
        $precio,
        $stock,
        $plataforma_id,
        $genero_id,
        $desarrolladora,
        $ano_lanzamiento
    );
    // 1. Instanciamos la clase Conexion para obtener el objeto PDO real
    $conexionObj = new Conexion();
    $conexionPDO = $conexionObj->getConexion();

    // 2. Le pasamos $conexionPDO al repositorio
    $repositorio = new Repositorio($conexionPDO);
    
    if ($repositorio->GuardarVideojuego($videojuego)) {
        echo "Videojuego guardado exitosamente. <a href='index.php'>Volver al catálogo</a>";
    } else {
        echo "Error al guardar el videojuego.";
    }
    }
?>
?>