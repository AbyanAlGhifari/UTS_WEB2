<form method="post" action="">
    <label>Fakultas:</label><br />
    <select name="fakultas_id" required>
        <option value="">Pilih Fakultas</option>
        <?php foreach ($fakultasList as $fak): ?>
            <option value="<?= e($fak['id']) ?>" <?php if (($item['fakultas_id'] ?? '') == $fak['id']) echo 'selected'; ?>>
                <?= e($fak['nama']) ?>
            </option>
        <?php endforeach ?>
    </select><br /><br />

    <label>Nama Jurusan:</label><br />
    <input type="text" name="nama" value="<?= e($item['nama'] ?? '') ?>" required /><br /><br />

    <button type="submit">Simpan</button>
    <a href="index.php?menu=jurusan">Batal</a>
</form>
