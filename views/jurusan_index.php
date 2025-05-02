<form method="get" action="index.php" class="search-form">
    <input type="hidden" name="menu" value="jurusan" />
    <input type="text" name="keyword" placeholder="Cari nama jurusan atau fakultas" value="<?= e($keyword) ?>" />
    <input type="submit" value="Cari" />
    <a href="index.php?menu=jurusan" class="btn">Reset</a>
    <a href="index.php?menu=jurusan&action=create" class="btn">Tambah Jurusan</a>
</form>
<table>
    <thead>
        <tr><th>ID</th><th>Nama Jurusan</th><th>Fakultas</th><th>Aksi</th></tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= e($item['id']) ?></td>
            <td><?= e($item['nama']) ?></td>
            <td><?= e($item['fakultas_nama']) ?></td>
            <td>
                <a href="index.php?menu=jurusan&action=edit&id=<?= e($item['id']) ?>" class="btn btn-edit">Edit</a>
                <a href="index.php?menu=jurusan&action=delete&id=<?= e($item['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
