<?php
session_start(); 

require_once 'clases/conexion.php';
require_once 'clases/repositorio.php';
require_once 'clases/videojuego.php';
require_once 'clases/dlc.php';
require_once 'clases/usuario.php';

$conexion = new Conexion();
$conexionPDO = $conexion->getConexion();

if($conexionPDO) {
    $repositorio = new Repositorio($conexionPDO);
    $videojuegos = $repositorio->obtenerVideojuegos();
    $dlcs = $repositorio->obtenerDLCs();
} else {
    echo "No se pudo establecer la conexión a la base de datos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Videojuegos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
<div>
    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="crearjuego.php"><button>Añadir Juego</button></a>
        <a href="creardlc.php"><button>Añadir DLC</button></a>
        <a href="logout.php"><button>Cerrar Sesión</button></a>

    <?php elseif (isset($_SESSION['usuario'])): ?>
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="logout.php"><button>Cerrar Sesión</button></a>

    <?php else: ?>
        <a href="login.php"><button>Iniciar Sesión</button></a>
    <?php endif; ?>
</div>
</header>
<body>
    <h1>Catálogo de Videojuegos</h1>
    <div class="catalogo">
        <?php if (!empty($videojuegos)): ?>
            <?php foreach ($videojuegos as $videojuego): ?>
    <div class="videojuego">
        <h2><?php echo $videojuego->getTitulo(); ?></h2>
        <p><?php echo $videojuego->getDesarrolladora(); ?></p>
        <p><?php echo $videojuego->getAnoLanzamiento(); ?></p>
        <p>Precio: $<?php echo $videojuego->getPrecio(); ?></p>
        <p>Stock: <?php echo $videojuego->getStock(); ?> unidades</p>
        <p>Género: <?php echo htmlspecialchars($videojuego->getGeneroNombre() ?: $videojuego->getGeneroId()); ?></p>
        <p>Plataforma: <?php echo htmlspecialchars($videojuego->getPlataformaNombre() ?: $videojuego->getPlataformaId()); ?></p>
        
        
        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
            <p>
                <a href="editar_juego.php?id=<?php echo $videojuego->getId(); ?>">
                    <button>Editar</button>
                </a>
                <form action="procesar_borrar_juego.php" method="POST" class="form-borrar" onsubmit="return confirm('¿Deseas borrar este juego?');">
                    <input type="hidden" name="id" value="<?php echo $videojuego->getId(); ?>">
                    <button type="submit">Borrar</button>
                </form>
            </p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
        <?php else: ?>
            <p>No hay videojuegos disponibles.</p>
        <?php endif; ?>
    </div>
    <h1>Contenido Descargable (DLCs)</h1>
    <div class="catalogo">
        <?php if (!empty($dlcs)): ?>
            <?php foreach ($dlcs as $dlc): ?>
                <div class="dlc">
                    <h2><?php echo $dlc->getTitulo(); ?></h2>
                    <p><strong>Descripción:</strong> <?php echo $dlc->getDescripcion(); ?></p>
                    <p><strong>Precio:</strong> <?php echo $dlc->getPrecio(); ?>€</p>
                    <p><strong>ID Juego Base:</strong> #<?php echo $dlc->getJuegoBaseId(); ?></p>
                            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
            <p>
                <a href="editar_dlc.php?id=<?php echo $dlc->getId(); ?>">
                    <button>Editar </button>
                </a>
                <form action="procesar_borrar_DLC.php" method="POST" class="form-borrar" onsubmit="return confirm('¿Deseas borrar este DLC?');">
                    <input type="hidden" name="id" value="<?php echo $dlc->getId(); ?>">
                    <button type="submit">Borrar</button>
                </form>
            </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay DLCs disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>