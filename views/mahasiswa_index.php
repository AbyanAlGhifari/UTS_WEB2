<form method="get" action="index.php" class="search-form">
    <input type="hidden" name="menu" value="mahasiswa" />
    <input type="text" name="keyword" placeholder="Cari nim, nama, jurusan, fakultas" value="<?= e($keyword) ?>" />
    <input type="submit" value="Cari" />
    <a href="index.php?menu=mahasiswa" class="btn">Reset</a>
    <a href="index.php?menu=mahasiswa&action=create" class="btn">Tambah Mahasiswa</a>
</form>
<table>
    <thead>
        <tr>
            <th>ID</th><th>NIM</th><th>Nama</th><th>Alamat</th><th>Jurusan</th><th>Fakultas</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= e($item['id']) ?></td>
            <td><?= e($item['nim']) ?></td>
            <td><?= e($item['nama']) ?></td>
            <td><?= e($item['alamat']) ?></td>
            <td><?= e($item['jurusan_nama']) ?></td>
            <td><?= e($item['fakultas_nama']) ?></td>
            <td>
                <a href="index.php?menu=mahasiswa&action=edit&id=<?= e($item['id']) ?>" class="btn btn-edit">Edit</a>
                <a href="index.php?menu=mahasiswa&action=delete&id=<?= e($item['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
