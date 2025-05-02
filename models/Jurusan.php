<?php
namespace Models;

class Jurusan extends BaseModel {
    protected $table = 'jurusan';

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO jurusan (fakultas_id, nama) VALUES (:fakultas_id, :nama)");
        return $stmt->execute([
            'fakultas_id' => $data['fakultas_id'],
            'nama' => $data['nama']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE jurusan SET fakultas_id = :fakultas_id, nama = :nama WHERE id = :id");
        return $stmt->execute([
            'fakultas_id' => $data['fakultas_id'],
            'nama' => $data['nama'],
            'id' => $id
        ]);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT jurusan.*, fakultas.nama as fakultas_nama FROM jurusan JOIN fakultas ON jurusan.fakultas_id=fakultas.id WHERE jurusan.nama LIKE :keyword OR fakultas.nama LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWithFakultas() {
        $stmt = $this->conn->prepare("SELECT jurusan.*, fakultas.nama as fakultas_nama FROM jurusan JOIN fakultas ON jurusan.fakultas_id=fakultas.id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
