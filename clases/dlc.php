<?php
require_once 'producto.php';
class DLC extends Producto {
    private $descripcion;
    private $juego_base_id;

    public function __construct($id, $titulo, $tipo, $precio, $stock, $juego_base_id, $descripcion) {
        parent::__construct($id, $titulo, $tipo, $precio, $stock);
        $this->juego_base_id = $juego_base_id;
        $this->descripcion = $descripcion;
    }

    public function getJuegoBaseId() {
        return $this->juego_base_id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }
}