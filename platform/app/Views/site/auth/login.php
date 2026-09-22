<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="card">
    <h1><?= esc(lang('Auth.login.title')) ?></h1>
    <?php if (! empty($notice)): ?>
        <p class="notice"><?= esc($notice) ?></p>
    <?php endif; ?>
    <form method="post" action="/login">
        <?= csrf_field() ?>
        <label for="email"><?= esc(lang('Auth.register.email')) ?></label>
        <input type="email" id="email" name="email" required autocomplete="email">

        <label for="password"><?= esc(lang('Auth.register.password')) ?></label>
        <input type="password" id="password" name="password" required autocomplete="current-password">

        <button type="submit"><?= esc(lang('Auth.login.submit')) ?></button>
    </form>
</div>
<?= $this->endSection() ?>
