<?= $this->include('template/header'); ?>

<h1><?= $title ?? 'About'; ?></h1>
<hr>
<p><?= $content ?? 'Halaman About sedang dalam pengembangan.'; ?></p>

<?= $this->include('template/footer'); ?>