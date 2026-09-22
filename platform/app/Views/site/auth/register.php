<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="card">
    <h1><?= esc(lang('Auth.register.title')) ?></h1>
    <?php if (! empty($notice)): ?>
        <p class="notice"><?= esc($notice) ?></p>
    <?php endif; ?>
    <form method="post" action="/register">
        <?= csrf_field() ?>
        <label for="name"><?= esc(lang('Auth.onboarding.company')) ?></label>
        <input type="text" id="name" name="name" required autocomplete="organization">

        <label for="email"><?= esc(lang('Auth.register.email')) ?></label>
        <input type="email" id="email" name="email" required autocomplete="email">

        <label for="password"><?= esc(lang('Auth.register.password')) ?></label>
        <input type="password" id="password" name="password" required autocomplete="new-password">

        <button type="submit"><?= esc(lang('Auth.register.submit')) ?></button>
    </form>
</div>
<?= $this->endSection() ?>
