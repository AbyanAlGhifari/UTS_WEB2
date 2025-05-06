<?php
// contoh namespace
namespace Models;

// inheritance mewarisi basemodel
class Mahasiswa extends BaseModel {
    protected $table = 'mahasiswa';

    // polymorphism
    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO mahasiswa (jurusan_id, nim, nama, alamat) VALUES (:jid, :nim, :nama, :alamat)");
        return $stmt->execute(['jid'=>$data['jurusan_id'],'nim'=>$data['nim'],'nama'=>$data['nama'],'alamat'=>$data['alamat']]);
    }

    // polymorphism
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE mahasiswa SET jurusan_id=:jid, nim=:nim, nama=:nama, alamat=:alamat WHERE id=:id");
        return $stmt->execute(['jid'=>$data['jurusan_id'],'nim'=>$data['nim'],'nama'=>$data['nama'],'alamat'=>$data['alamat'],'id'=>$id]);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT mahasiswa.*, jurusan.nama as jurusan_nama, fakultas.nama as fakultas_nama FROM mahasiswa JOIN jurusan ON mahasiswa.jurusan_id=jurusan.id JOIN fakultas ON jurusan.fakultas_id=fakultas.id WHERE mahasiswa.nim LIKE :kw OR mahasiswa.nama LIKE :kw OR jurusan.nama LIKE :kw OR fakultas.nama LIKE :kw");
        $stmt->execute(['kw' => "%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWithRelations() {
        $stmt = $this->conn->prepare("SELECT mahasiswa.*, jurusan.nama as jurusan_nama, fakultas.nama as fakultas_nama FROM mahasiswa JOIN jurusan ON mahasiswa.jurusan_id=jurusan.id JOIN fakultas ON jurusan.fakultas_id=fakultas.id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
