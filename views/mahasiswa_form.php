<form method="post" action="">
    <label>NIM:</label><br />
    <input type="text" name="nim" value="<?= e($item['nim'] ?? '') ?>" required /><br /><br />

    <label>Nama Mahasiswa:</label><br />
    <input type="text" name="nama" value="<?= e($item['nama'] ?? '') ?>" required /><br /><br />

    <label>Alamat:</label><br />
    <textarea name="alamat" rows="3"><?= e($item['alamat'] ?? '') ?></textarea><br /><br />

    <label>Jurusan:</label><br />
    <select name="jurusan_id" required>
        <option value="">Pilih Jurusan</option>
        <?php foreach ($jurusanList as $jur) : ?>
            <option value="<?= e($jur['id']) ?>" <?php if (($item['jurusan_id'] ?? '') == $jur['id']) echo 'selected'; ?>>
                <?= e($jur['nama']) ?> (<?= e($jur['fakultas_nama']) ?>)
            </option>
        <?php endforeach ?>
    </select><br /><br />

    <button type="submit">Simpan</button>
    <a href="index.php?menu=mahasiswa">Batal</a>
</form>
