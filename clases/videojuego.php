<?php
require_once 'producto.php';
class Videojuego extends Producto {
    private $desarrolladora;
    private $anoLanzamiento;
    private $generoid;
    private $plataforma_id;
    private $generoNombre;
    private $plataformaNombre;

    public function __construct($id, $titulo, $tipo, $precio, $stock, $plataforma_id, $generoid, $desarrolladora, $anoLanzamiento, $generoNombre = null, $plataformaNombre = null) {
        parent::__construct($id, $titulo, $tipo, $precio, $stock);
        $this->plataforma_id = $plataforma_id;
        $this->generoid = $generoid;
        $this->desarrolladora = $desarrolladora;
        $this->anoLanzamiento = $anoLanzamiento;
        $this->generoNombre = $generoNombre;
        $this->plataformaNombre = $plataformaNombre;
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function getPlataformaId() {
        return $this->plataforma_id;
    }

    public function getGeneroId() {
        return $this->generoid;
    }

    public function getGeneroNombre() {
        return $this->generoNombre;
    }

    public function getPlataformaNombre() {
        return $this->plataformaNombre;
    }

    public function getDesarrolladora() {
        return $this->desarrolladora;
    }

    public function getAnoLanzamiento() {
        return $this->anoLanzamiento;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getStock() {
        return $this->stock;
    }
    
}
?>
