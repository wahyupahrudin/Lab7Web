<?= $this->include('template/header'); ?>

<?php if (isset($artikel) && !empty($artikel)): ?>
    <article class="entry">
        <h2><?= esc($artikel['judul']); ?></h2>
        <p><strong>Kategori:</strong> <?= esc($artikel['nama_kategori'] ?? 'Tanpa Kategori'); ?></p>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= esc($artikel['judul']); ?>">
        <p><?= esc($artikel['isi']); ?></p>
    </article>
<?php else: ?>
    <article class="entry">
        <h2>Artikel tidak ditemukan.</h2>
    </article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>