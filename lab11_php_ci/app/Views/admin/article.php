<?= $this->include('template/admin_header'); ?>

<!-- FORM PENCARIAN -->
<form method="get">
    <input type="text" name="q" value="<?= $q ?? ''; ?>" placeholder="Cari judul">
    <button type="submit">Cari</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($artikel) && !empty($artikel)): ?>
            <?php foreach ($artikel as $row): ?>
            <tr>
                <td><?= esc($row['id']); ?></td>
                <td>
                    <b><?= esc($row['judul']); ?></b>
                    <p><small><?= esc(substr($row['isi'], 0, 50)); ?>...</small></p>
                </td>
                <td><?= $row['status'] == 1 ? 'Publish' : 'Draft'; ?></td>
                <td>
                    <a class="btn" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                    <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data ini?');" 
                       href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Belum ada data.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->include('template/admin_footer'); ?>