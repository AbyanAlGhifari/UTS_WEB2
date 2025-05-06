<?php
// contoh namespace
namespace Controllers;

use Models\Mahasiswa;

class MahasiswaController {
    private $model;

    public function __construct() {
        $this->model = new Mahasiswa();
    }

    public function index($keyword='') {
        if ($keyword) return $this->model->search($keyword);
        return $this->model->getWithRelations();
    }

    public function create($data) { return $this->model->insert($data);}
    public function find($id) { return $this->model->getById($id);}
    public function update($id,$data) { return $this->model->update($id,$data);}
    public function delete($id) { return $this->model->delete($id);}
}
?>
