<?= $this->include('template/header'); ?>

<h2><?= $title ?? 'Daftar Artikel'; ?></h2>

<?php if (isset($artikel) && !empty($artikel)): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= esc($row['judul']); ?></a></h2>
            <p><strong>Kategori:</strong> <?= esc($row['nama_kategori'] ?? 'Tanpa Kategori'); ?></p>
            <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= esc($row['judul']); ?>">
            <p><?= esc(substr($row['isi'], 0, 200)); ?>...</p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada data.</h2>
    </article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>