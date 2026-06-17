<?php
use PHPUnit\Framework\TestCase;

// Importamos tu clase original para poder testearla
require_once __DIR__ . '/clases/videojuego.php';

class VideojuegoTest extends TestCase {

    public function testCreacionYGettersDeVideojuego() {
        // 1. Datos de prueba
        $id = 1;
        $titulo = "The Legend of Zelda";
        $tipo = "Videojuego";
        $precio = 59.99;
        $stock = 10;
        $plataforma_id = 2;
        $genero_id = 3;
        $desarrolladora = "Nintendo";
        $ano_lanzamiento = 2023;

        // 2. Instanciamos el objeto
        $videojuego = new Videojuego(
            $id,
            $titulo,
            $tipo,
            $precio,
            $stock,
            $plataforma_id,
            $genero_id,
            $desarrolladora,
            $ano_lanzamiento
        );

        // 3. Comprobamos que los métodos devuelven lo correcto
        $this->assertEquals($id, $videojuego->getId());
        $this->assertEquals($titulo, $videojuego->getTitulo());
        $this->assertEquals($precio, $videojuego->getPrecio());
        $this->assertEquals($desarrolladora, $videojuego->getDesarrolladora());
        $this->assertEquals($ano_lanzamiento, $videojuego->getAnoLanzamiento());
    }
}
?>