<?php
// contoh namespace
namespace Models;

use Config\Database;
use PDO;

// inheritance 
abstract class BaseModel {
    protected $conn;
    protected $table;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Encapsulation 

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // polymorphism insert dan update untuk diimplementasikan pada fakultas jurusan dan mahasiswa
    abstract public function insert($data);

    abstract public function update($id, $data);

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id'=>$id]);
    }

    // polymorphism search
    public function search($keyword) {
        return [];
    }
}
?>
