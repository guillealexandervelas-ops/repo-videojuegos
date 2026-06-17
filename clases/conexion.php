<?php

class Conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $password = "";
    private $bd = "catalogo_videojuegos_poo";
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->bd}", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion() {
    return $this->conexion;
}
}

?>