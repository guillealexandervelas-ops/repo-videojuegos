<?php
// 1. Iniciamos la sesión para poder guardar los datos del usuario
session_start();

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 2. Conectamos a la base de datos e instanciamos el repositorio
    $conexionObj = new Conexion();
    $conexionPDO = $conexionObj->getConexion();
    $repositorio = new Repositorio($conexionPDO);

    // 3. Buscamos si el usuario existe
    $usuario = $repositorio->obtenerUsuarioPorUsername($username);

    // 4. Comprobamos si existe el usuario y si la contraseña coincide directamente
    if ($usuario !== null && $password === $usuario->getPassword()) {
        // ¡Credenciales correctas! Guardamos los datos en la sesión
        $_SESSION['usuario'] = $usuario->getUsername();
        $_SESSION['usuario_rol'] = $usuario->getRol();

        // Redirigimos al catálogo principal
        header('Location: index.php');
        exit();
    }

    // Si llega aquí, es que el usuario o la contraseña fallaron
    echo "Usuario o contraseña incorrectos. <a href='login.php'>Volver a intentarlo</a>";
} else {
    echo "Método no permitido.";
}
?>