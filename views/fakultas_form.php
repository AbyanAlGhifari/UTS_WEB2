<form method="post" action="">
    <label>Nama Fakultas:</label><br />
    <input type="text" name="nama" value="<?= e($item['nama'] ?? '') ?>" required /><br /><br />
    <button type="submit">Simpan</button>
    <a href="index.php?menu=fakultas">Batal</a>
</form>
