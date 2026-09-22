<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="card">
    <h1><?= esc(lang('Auth.recovery.title')) ?></h1>
    <?php if (! empty($notice)): ?>
        <p class="notice"><?= esc($notice) ?></p>
    <?php endif; ?>
    <form method="post" action="/recovery">
        <?= csrf_field() ?>
        <label for="email"><?= esc(lang('Auth.register.email')) ?></label>
        <input type="email" id="email" name="email" required autocomplete="email">

        <button type="submit"><?= esc(lang('Auth.recovery.title')) ?></button>
    </form>
</div>
<?= $this->endSection() ?>
