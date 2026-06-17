<?php
require_once 'videojuego.php';
require_once 'usuario.php';

class Repositorio {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerVideojuegos() {
        $sql = "SELECT v.*, g.nombre AS genero_nombre, p.nombre AS plataforma_nombre
                FROM videojuegos v
                LEFT JOIN generos g ON v.genero_id = g.id
                LEFT JOIN plataformas p ON v.plataforma_id = p.id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $videojuegos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $videojuegos[] = new Videojuego(
                $row['id'],
                $row['titulo'],
                'Videojuego',
                $row['precio'],
                $row['stock'],
                $row['plataforma_id'],
                $row['genero_id'],
                $row['desarrolladora'],
                $row['ano_lanzamiento'],
                $row['genero_nombre'],
                $row['plataforma_nombre']
            );
        }
        return $videojuegos;
    }

    public function obtenerDLCs() {
        $sql = "SELECT * FROM dlcs"; 
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        
        $dlcs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dlcs[] = new DLC(
                $row['id'],
                $row['titulo'],
                'DLC', 
                $row['precio'],
                $row['stock'],
                $row['juego_base_id'],
                $row['descripcion']
            );
        }
        return $dlcs;
    }

    public function GuardarVideojuego(Videojuego $videojuego) {
        $sql = "INSERT INTO videojuegos (titulo, desarrolladora, ano_lanzamiento, genero_id, plataforma_id, precio, stock) 
                VALUES (:titulo, :desarrolladora, :ano_lanzamiento, :genero_id, :plataforma_id, :precio, :stock)";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':titulo'           => $videojuego->getTitulo(),
            ':desarrolladora'   => $videojuego->getDesarrolladora(),
            ':ano_lanzamiento'  => $videojuego->getAnoLanzamiento(), 
            ':genero_id'        => $videojuego->getGeneroId(),
            ':plataforma_id'    => $videojuego->getPlataformaId(),
            ':precio'           => $videojuego->getPrecio(),
            ':stock'            => $videojuego->getStock()
        ]);
    }

    public function obtenerUsuarioPorUsername($username) {
        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':username' => $username]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Usuario(
                $row['id'],
                $row['username'],
                $row['password'],
                $row['rol']
            );
        }

        return null;
    }

    public function GuardarDLC(DLC $dlc) {
        $sql = "INSERT INTO dlcs (titulo, juego_base_id, descripcion, precio, stock) 
                VALUES (:titulo, :juego_base_id, :descripcion, :precio, :stock)";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':titulo'           => $dlc->getTitulo(),
            ':juego_base_id'    => $dlc->getJuegoBaseId(),
            ':descripcion'      => $dlc->getDescripcion(),
            ':precio'           => $dlc->getPrecio(),
            ':stock'            => $dlc->getStock()
        ]);
    }
public function obtenerVideojuegoPorId($id) {
    $sql = "SELECT v.*, g.nombre AS genero_nombre, p.nombre AS plataforma_nombre
            FROM videojuegos v
            LEFT JOIN generos g ON v.genero_id = g.id
            LEFT JOIN plataformas p ON v.plataforma_id = p.id
            WHERE v.id = :id";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([':id' => $id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return new Videojuego(
            $row['id'],
            $row['titulo'],
            'Videojuego',
            $row['precio'],
            $row['stock'],
            $row['plataforma_id'],
            $row['genero_id'],
            $row['desarrolladora'],
            $row['ano_lanzamiento'],
            $row['genero_nombre'],
            $row['plataforma_nombre']
        );
    }
    return null;
}
public function actualizarVideojuego(Videojuego $videojuego) {
    $sql = "UPDATE videojuegos 
            SET titulo = :titulo, 
                desarrolladora = :desarrolladora, 
                ano_lanzamiento = :ano_lanzamiento, 
                genero_id = :genero_id, 
                plataforma_id = :plataforma_id, 
                precio = :precio, 
                stock = :stock 
            WHERE id = :id";
    
    $stmt = $this->conexion->prepare($sql);
    
    return $stmt->execute([
        ':id'               => $videojuego->getId(),
        ':titulo'           => $videojuego->getTitulo(),
        ':desarrolladora'   => $videojuego->getDesarrolladora(),
        ':ano_lanzamiento'  => $videojuego->getAnoLanzamiento(),
        ':genero_id'        => $videojuego->getGeneroId(),
        ':plataforma_id'    => $videojuego->getPlataformaId(),
        ':precio'           => $videojuego->getPrecio(),
        ':stock'            => $videojuego->getStock()
    ]);
}

    public function eliminarVideojuego($id) {
        $sql = "DELETE FROM dlcs WHERE juego_base_id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        $sql = "DELETE FROM videojuegos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function eliminarDLC($id) {
        $sql = "DELETE FROM dlcs WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    
        $sql = "DELETE FROM dlcs WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function obtenerDLCPorId($id) {
        $sql = "SELECT * FROM dlcs WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new DLC(
                $row['id'],
                $row['titulo'],
                'DLC',
                $row['precio'],
                $row['stock'],
                $row['juego_base_id'],
                $row['descripcion']
            );
        }
        return null;
    }

    public function actualizarDLC(DLC $dlc) {
        $sql = "UPDATE dlcs 
                SET titulo = :titulo, 
                    juego_base_id = :juego_base_id, 
                    descripcion = :descripcion, 
                    precio = :precio, 
                    stock = :stock 
                WHERE id = :id";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':id'               => $dlc->getId(),
            ':titulo'           => $dlc->getTitulo(),
            ':juego_base_id'    => $dlc->getJuegoBaseId(),
            ':descripcion'      => $dlc->getDescripcion(),
            ':precio'           => $dlc->getPrecio(),
            ':stock'            => $dlc->getStock()
        ]);
    }
}
 