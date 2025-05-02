<?php

require_once __DIR__ . '/config/Database.php';

spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';

    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use Controllers\FakultasController;
use Controllers\JurusanController;
use Controllers\MahasiswaController;

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$pageTitle = "Dashboard";

$menu = $_GET['menu'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;
$keyword = $_GET['keyword'] ?? '';

ob_start();

switch ($menu) {
    case 'fakultas':
        $ctrl = new FakultasController();
        $pageTitle = "Kelola Fakultas";

        if ($action == 'index') {
            $items = $ctrl->index($keyword);
            include __DIR__ . '/views/fakultas_index.php';
        } elseif ($action == 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nama = $_POST['nama'] ?? '';
                if ($nama) {
                    $ctrl->create(['nama' => $nama]);
                    header('Location: index.php?menu=fakultas');
                    exit;
                }
            }
            include __DIR__ . '/views/fakultas_form.php';
        } elseif ($action == 'edit' && $id) {
            $item = $ctrl->find($id);
            if (!$item) {
                echo "<p>Data tidak ditemukan</p>";
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nama = $_POST['nama'] ?? '';
                    if ($nama) {
                        $ctrl->update($id, ['nama' => $nama]);
                        header('Location: index.php?menu=fakultas');
                        exit;
                    }
                }
                include __DIR__ . '/views/fakultas_form.php';
            }
        } elseif ($action == 'delete' && $id) {
            $ctrl->delete($id);
            header('Location: index.php?menu=fakultas');
            exit;
        }
        break;

    case 'jurusan':
        $ctrl = new JurusanController();
        $pageTitle = "Kelola Jurusan";

        if ($action == 'index') {
            $items = $ctrl->index($keyword);
            include __DIR__ . '/views/jurusan_index.php';
        } elseif ($action == 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nama = $_POST['nama'] ?? '';
                $fakultas_id = $_POST['fakultas_id'] ?? '';
                if ($nama && $fakultas_id) {
                    $ctrl->create(['fakultas_id' => $fakultas_id, 'nama' => $nama]);
                    header('Location: index.php?menu=jurusan');
                    exit;
                }
            }
            $fakultasCtrl = new FakultasController();
            $fakultasList = $fakultasCtrl->index();
            include __DIR__ . '/views/jurusan_form.php';
        } elseif ($action == 'edit' && $id) {
            $item = $ctrl->find($id);
            if (!$item) {
                echo "<p>Data tidak ditemukan</p>";
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nama = $_POST['nama'] ?? '';
                    $fakultas_id = $_POST['fakultas_id'] ?? '';
                    if ($nama && $fakultas_id) {
                        $ctrl->update($id, ['fakultas_id' => $fakultas_id, 'nama' => $nama]);
                        header('Location: index.php?menu=jurusan');
                        exit;
                    }
                }
                $fakultasCtrl = new FakultasController();
                $fakultasList = $fakultasCtrl->index();
                include __DIR__ . '/views/jurusan_form.php';
            }
        } elseif ($action == 'delete' && $id) {
            $ctrl->delete($id);
            header('Location: index.php?menu=jurusan');
            exit;
        }
        break;

    case 'mahasiswa':
        $ctrl = new MahasiswaController();
        $pageTitle = "Kelola Mahasiswa";

        if ($action == 'index') {
            $items = $ctrl->index($keyword);
            include __DIR__ . '/views/mahasiswa_index.php';
        } elseif ($action == 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nim = $_POST['nim'] ?? '';
                $namaMhs = $_POST['nama'] ?? '';
                $alamat = $_POST['alamat'] ?? '';
                $jurusan_id = $_POST['jurusan_id'] ?? '';
                if ($nim && $namaMhs && $jurusan_id) {
                    $ctrl->create([
                        'nim' => $nim,
                        'nama' => $namaMhs,
                        'alamat' => $alamat,
                        'jurusan_id' => $jurusan_id
                    ]);
                    header('Location: index.php?menu=mahasiswa');
                    exit;
                }
            }
            $jurusanCtrl = new JurusanController();
            $jurusanList = $jurusanCtrl->index();
            include __DIR__ . '/views/mahasiswa_form.php';
        } elseif ($action == 'edit' && $id) {
            $item = $ctrl->find($id);
            if (!$item) {
                echo "<p>Data tidak ditemukan</p>";
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nim = $_POST['nim'] ?? '';
                    $namaMhs = $_POST['nama'] ?? '';
                    $alamat = $_POST['alamat'] ?? '';
                    $jurusan_id = $_POST['jurusan_id'] ?? '';
                    if ($nim && $namaMhs && $jurusan_id) {
                        $ctrl->update($id, [
                            'nim' => $nim,
                            'nama' => $namaMhs,
                            'alamat' => $alamat,
                            'jurusan_id' => $jurusan_id
                        ]);
                        header('Location: index.php?menu=mahasiswa');
                        exit;
                    }
                }
                $jurusanCtrl = new JurusanController();
                $jurusanList = $jurusanCtrl->index();
                include __DIR__ . '/views/mahasiswa_form.php';
            }
        } elseif ($action == 'delete' && $id) {
            $ctrl->delete($id);
            header('Location: index.php?menu=mahasiswa');
            exit;
        }
        break;

    default:
        $pageTitle = "Dashboard";
        include __DIR__ . '/views/home.php';
        break;
}

$content = ob_get_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= e($pageTitle) ?></title>
    <style>
        /* Reset */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
                Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            margin: 20px auto;
            max-width: 900px;
            padding: 0 15px;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .nav {
            margin-bottom: 25px;
        }
        .nav a {
            margin-right: 15px;
            text-decoration: none;
            font-weight: 600;
            color: #2980b9;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .nav a:hover,
        .nav a.active {
            background-color: #2980b9;
            color: #fff;
        }
        form.search-form {
            margin-bottom: 15px;
        }
        form.search-form input[type="text"],
        form.search-form select {
            padding: 8px 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
            max-width: 100%;
            margin-right: 8px;
            transition: border-color 0.3s ease;
        }
        form.search-form input[type="text"]:focus,
        form.search-form select:focus {
            border-color: #2980b9;
            outline: none;
        }
        form.search-form input[type="submit"],
        button,
        .btn {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        form.search-form input[type="submit"]:hover,
        button:hover,
        .btn:hover {
            background-color: #1c5980;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 10px 12px;
        }
        th {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f2f6fa;
        }
        tr:hover {
            background-color: #e1efff;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }
        input[type="text"],
        select,
        textarea {
            width: 100%;
            max-width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #2980b9;
            outline: none;
        }
        textarea {
            resize: vertical;
        }
        .btn-danger {
            background-color: #c0392b;
        }
        .btn-danger:hover {
            background-color: #81281f;
        }
        .btn-edit {
            background-color: #27ae60;
        }
        .btn-edit:hover {
            background-color: #1e7d44;
        }
        a.btn {
            text-align: center;
        }
        /* Responsive */
        @media (max-width: 600px) {
            body {
                margin: 10px;
                padding: 0 10px;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                padding: 10px;
                background: white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            td {
                border: none;
                padding: 6px 10px;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: 600;
                color: #333;
            }
            td:nth-of-type(1):before { content: "ID"; }
            td:nth-of-type(2):before { content: "Name"; }
            td:nth-of-type(3):before { content: "Action"; }
        }
    </style>
</head>
<body>
    <h1><?= e($pageTitle) ?></h1>
    <div class="nav">
        <a href="index.php" class="<?= $menu === 'home' ? 'active' : '' ?>">Dashboard</a>
        <a href="index.php?menu=fakultas" class="<?= $menu === 'fakultas' ? 'active' : '' ?>">Kelola Fakultas</a>
        <a href="index.php?menu=jurusan" class="<?= $menu === 'jurusan' ? 'active' : '' ?>">Kelola Jurusan</a>
        <a href="index.php?menu=mahasiswa" class="<?= $menu === 'mahasiswa' ? 'active' : '' ?>">Kelola Mahasiswa</a>
    </div>

    <?= $content ?>
</body>
</html>