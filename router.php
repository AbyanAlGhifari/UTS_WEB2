<?php
use Controllers\FakultasController;
use Controllers\JurusanController;
use Controllers\MahasiswaController;

function routeRequest($menu, $action, $id, $keyword) {
    ob_start();
    $menu = strtolower($menu);

    $routes = [
        'fakultas' => function() use ($action, $id, $keyword) {
            $ctrl = new FakultasController();
            if ($action === 'index') {
                $items = $ctrl->index($keyword);
                include __DIR__ . '/views/fakultas_index.php';
            } elseif ($action === 'create') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nama'])) {
                    $ctrl->create(['nama' => $_POST['nama']]);
                    header('Location:index.php?menu=fakultas');
                    exit;
                }
                include __DIR__ . '/views/fakultas_form.php';
            } elseif ($action === 'edit' && $id) {
                $item = $ctrl->find($id);
                if (!$item) {
                    echo "<p>Data tidak ditemukan</p>";
                } else {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nama'])) {
                        $ctrl->update($id, ['nama' => $_POST['nama']]);
                        header('Location:index.php?menu=fakultas');
                        exit;
                    }
                    include __DIR__ . '/views/fakultas_form.php';
                }
            } elseif ($action === 'delete' && $id) {
                $ctrl->delete($id);
                header('Location:index.php?menu=fakultas');
                exit;
            }
        },
        'jurusan' => function() use ($action, $id, $keyword) {
            $ctrl = new JurusanController();
            if ($action === 'index') {
                $items = $ctrl->index($keyword);
                include __DIR__ . '/views/jurusan_index.php';
            } elseif ($action === 'create') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nama']) && !empty($_POST['fakultas_id'])) {
                    $ctrl->create(['nama' => $_POST['nama'], 'fakultas_id' => $_POST['fakultas_id']]);
                    header('Location:index.php?menu=jurusan');
                    exit;
                }
                $fakultasCtrl = new FakultasController();
                $fakultasList = $fakultasCtrl->index();
                include __DIR__ . '/views/jurusan_form.php';
            } elseif ($action === 'edit' && $id) {
                $item = $ctrl->find($id);
                if (!$item) {
                    echo "<p>Data tidak ditemukan</p>";
                } else {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nama']) && !empty($_POST['fakultas_id'])) {
                        $ctrl->update($id, ['nama' => $_POST['nama'], 'fakultas_id' => $_POST['fakultas_id']]);
                        header('Location:index.php?menu=jurusan');
                        exit;
                    }
                    $fakultasCtrl = new FakultasController();
                    $fakultasList = $fakultasCtrl->index();
                    include __DIR__ . '/views/jurusan_form.php';
                }
            } elseif ($action === 'delete' && $id) {
                $ctrl->delete($id);
                header('Location:index.php?menu=jurusan');
                exit;
            }
        },
        'mahasiswa' => function() use ($action, $id, $keyword) {
            $ctrl = new MahasiswaController();
            if ($action === 'index') {
                $items = $ctrl->index($keyword);
                include __DIR__ . '/views/mahasiswa_index.php';
            } elseif ($action === 'create') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nim']) && !empty($_POST['nama']) && !empty($_POST['jurusan_id'])) {
                    $ctrl->create([
                        'nim' => $_POST['nim'],
                        'nama' => $_POST['nama'],
                        'alamat' => $_POST['alamat'] ?? '',
                        'jurusan_id' => $_POST['jurusan_id']
                    ]);
                    header('Location:index.php?menu=mahasiswa');
                    exit;
                }
                $jurusanCtrl = new JurusanController();
                $jurusanList = $jurusanCtrl->index();
                include __DIR__ . '/views/mahasiswa_form.php';
            } elseif ($action === 'edit' && $id) {
                $item = $ctrl->find($id);
                if (!$item) {
                    echo "<p>Data tidak ditemukan</p>";
                } else {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nim']) && !empty($_POST['nama']) && !empty($_POST['jurusan_id'])) {
                        $ctrl->update($id, [
                            'nim' => $_POST['nim'],
                            'nama' => $_POST['nama'],
                            'alamat' => $_POST['alamat'] ?? '',
                            'jurusan_id' => $_POST['jurusan_id']
                        ]);
                        header('Location:index.php?menu=mahasiswa');
                        exit;
                    }
                    $jurusanCtrl = new JurusanController();
                    $jurusanList = $jurusanCtrl->index();
                    include __DIR__ . '/views/mahasiswa_form.php';
                }
            } elseif ($action === 'delete' && $id) {
                $ctrl->delete($id);
                header('Location:index.php?menu=mahasiswa');
                exit;
            }
        }
    ];

    if (isset($routes[$menu])) {
        $routes[$menu]();
    } else {
        $pageTitle = "Dashboard";
        include __DIR__ . '/views/home.php';
    }

    return ob_get_clean();
}