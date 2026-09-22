<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="page-title"><?= esc(lang('App.nav.dashboard')) ?></h1>
<div class="grid">
    <section class="bento">
        <h2><?= esc(lang('App.nav.agents')) ?></h2>
        <p><?= esc(lang('App.msg.empty')) ?></p>
    </section>
    <section class="bento">
        <h2><?= esc(lang('App.nav.executions')) ?></h2>
        <p><?= esc(lang('App.msg.empty')) ?></p>
    </section>
</div>
<?= $this->endSection() ?>
