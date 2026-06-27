<?= $this->include('template/admin_header'); ?>

<h2><?= $title ?? 'Tambah Artikel'; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" name="judul" id="judul" required>
    </p>
    <p>
        <label for="isi">Isi Artikel</label><br>
        <textarea name="isi" id="isi" cols="50" rows="10" required></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori</label><br>
        <select name="id_kategori" id="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php if (isset($kategori) && !empty($kategori)): ?>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"><?= esc($k['nama_kategori']); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </p>
    <p>
        <label for="gambar">Gambar</label><br>
        <input type="file" name="gambar" id="gambar">
    </p>
    <p>
        <label for="status">Status</label><br>
        <select name="status" id="status">
            <option value="0">Draft</option>
            <option value="1">Publish</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Simpan" class="btn btn-primary">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>