<?= $this->include('template/admin_header'); ?>

<h2><?= $title ?? 'Edit Artikel'; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" name="judul" id="judul" value="<?= esc($data['judul'] ?? ''); ?>" required>
    </p>
    <p>
        <label for="isi">Isi Artikel</label><br>
        <textarea name="isi" id="isi" cols="50" rows="10" required><?= esc($data['isi'] ?? ''); ?></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori</label><br>
        <select name="id_kategori" id="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php if (isset($kategori) && !empty($kategori)): ?>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= isset($data['id_kategori']) && $data['id_kategori'] == $k['id_kategori'] ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </p>
    <p>
        <label for="gambar">Gambar</label><br>
        <input type="file" name="gambar" id="gambar">
        <?php if (!empty($data['gambar'])): ?>
            <small>Gambar saat ini: <?= esc($data['gambar']); ?></small>
        <?php endif; ?>
    </p>
    <p>
        <label for="status">Status</label><br>
        <select name="status" id="status">
            <option value="0" <?= isset($data['status']) && $data['status'] == 0 ? 'selected' : ''; ?>>Draft</option>
            <option value="1" <?= isset($data['status']) && $data['status'] == 1 ? 'selected' : ''; ?>>Publish</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Update" class="btn btn-primary">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>