<!DOCTYPE html>
<html lang="<?= esc(service('request')->getLocale()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? lang('App.appName')) ?> · <?= esc(lang('App.appName')) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/public.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body>
    <header class="topbar">
        <a class="brand" href="/"><?= esc(lang('App.appName')) ?></a>
        <nav aria-label="public">
            <?php foreach (menu_items('public') as $item): ?>
                <a href="<?= esc($item['route']) ?>"><?= esc($item['text']) ?></a>
            <?php endforeach; ?>
        </nav>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer><?= esc(lang('App.appDescription')) ?></footer>
</body>
</html>
