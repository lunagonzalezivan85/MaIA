<!DOCTYPE html>
<html lang="<?= esc(service('request')->getLocale()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? '') ?> · <?= esc(lang('App.appName')) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body>
    <aside class="sidebar">
        <a class="brand" href="/dashboard"><?= esc(lang('App.appName')) ?></a>
        <nav aria-label="private">
            <?php
            $current = '/' . ltrim(uri_string(), '/');
            foreach (private_menu_items() as $item):
                $active = $current === $item['route'] ? ' class="active" aria-current="page"' : '';
            ?>
                <a href="<?= esc($item['route']) ?>"<?= $active ?>><?= esc($item['text']) ?></a>
            <?php endforeach; ?>
        </nav>
        <a class="logout" href="/logout"><?= esc(lang('App.nav.logout')) ?></a>
    </aside>

    <header class="topbar">
        <span><?= esc($title ?? '') ?></span>
        <span class="tenant"><?= esc(session('tenant_name') ?? '') ?></span>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
