<?php

class Usuario {
    private $id;
    private $username;
    private $password;
    private $rol;

    // Esto es para que el rol por defecto sea usuarionormal
    public function __construct($id, $username, $password, $rol = 'usuario_normal') {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function esAdmin() {
        return $this->rol === 'admin';
    }
}
?>