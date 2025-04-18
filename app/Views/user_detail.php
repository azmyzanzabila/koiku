<?= $this->extend('layout/post_layout') ?>

<?= $this->section('content') ?>
<h2 class="h2"><?= esc($user['nama']) ?></h2>
<div class="mb-5">
	<span><?= esc($user['created_at']->format('d-m-Y H:i:s')) ?></span>
</div>

<?= $this->endSection() ?>