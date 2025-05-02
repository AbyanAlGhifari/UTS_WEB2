<?php
namespace Models;

// inheritance mewarisi basemodel
class Fakultas extends BaseModel {
    protected $table = 'fakultas';

    // polymorphism
    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO fakultas (nama) VALUES (:nama)");
        return $stmt->execute(['nama' => $data['nama']]);
    }

    // polymorphism
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE fakultas SET nama = :nama WHERE id = :id");
        return $stmt->execute(['nama' => $data['nama'], 'id' => $id]);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM fakultas WHERE nama LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
