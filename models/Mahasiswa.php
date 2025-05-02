<?php
namespace Models;

class Mahasiswa extends BaseModel {
    protected $table = 'mahasiswa';

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO mahasiswa (jurusan_id, nim, nama, alamat) VALUES (:jurusan_id, :nim, :nama, :alamat)");
        return $stmt->execute([
            'jurusan_id' => $data['jurusan_id'],
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'alamat' => $data['alamat']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE mahasiswa SET jurusan_id = :jurusan_id, nim = :nim, nama = :nama, alamat = :alamat WHERE id = :id");
        return $stmt->execute([
            'jurusan_id' => $data['jurusan_id'],
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'id' => $id
        ]);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT mahasiswa.*, jurusan.nama as jurusan_nama, fakultas.nama as fakultas_nama FROM mahasiswa JOIN jurusan ON mahasiswa.jurusan_id=jurusan.id JOIN fakultas ON jurusan.fakultas_id=fakultas.id WHERE mahasiswa.nim LIKE :keyword OR mahasiswa.nama LIKE :keyword OR jurusan.nama LIKE :keyword OR fakultas.nama LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWithRelations() {
        $stmt = $this->conn->prepare("SELECT mahasiswa.*, jurusan.nama as jurusan_nama, fakultas.nama as fakultas_nama FROM mahasiswa JOIN jurusan ON mahasiswa.jurusan_id=jurusan.id JOIN fakultas ON jurusan.fakultas_id=fakultas.id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
