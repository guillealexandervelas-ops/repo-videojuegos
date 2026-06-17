<?php

Class Producto {
    private $id;
    protected $titulo;
    protected $tipo;
    protected $precio;
    protected $stock;

    public function __construct($id, $titulo, $tipo, $precio, $stock) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    // Getters y setters para cada propiedad
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }
}