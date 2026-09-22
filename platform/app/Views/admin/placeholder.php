<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="page-title"><?= esc($section) ?></h1>
<div class="bento">
    <p><?= esc(lang('App.msg.sectionWip', [$section])) ?></p>
</div>
<?= $this->endSection() ?>
