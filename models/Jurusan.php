<?php
// contoh namespace
namespace Models;

// inheritance mewarisi basemodel
class Jurusan extends BaseModel {
    protected $table = 'jurusan';

    // polymorphism
    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO jurusan (fakultas_id,nama) VALUES (:fid,:nama)");
        return $stmt->execute(['fid'=>$data['fakultas_id'],'nama'=>$data['nama']]);
    }
    
    // polymorphism
    public function update($id,$data) {
        $stmt = $this->conn->prepare("UPDATE jurusan SET fakultas_id=:fid, nama=:nama WHERE id=:id");
        return $stmt->execute(['fid'=>$data['fakultas_id'],'nama'=>$data['nama'],'id'=>$id]);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT jurusan.*, fakultas.nama as fakultas_nama FROM jurusan JOIN fakultas ON jurusan.fakultas_id=fakultas.id WHERE jurusan.nama LIKE :kw OR fakultas.nama LIKE :kw");
        $stmt->execute(['kw'=>"%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWithFakultas() {
        $stmt = $this->conn->prepare("SELECT jurusan.*, fakultas.nama as fakultas_nama FROM jurusan JOIN fakultas ON jurusan.fakultas_id=fakultas.id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
