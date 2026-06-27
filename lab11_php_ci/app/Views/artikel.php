<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title ?? 'Home' ?></h1>
<hr>
<p><?= $content ?? 'Selamat datang di website kami.' ?></p>
<?= $this->endSection() ?>