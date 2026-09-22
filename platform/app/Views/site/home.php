<?= $this->extend('layouts/public') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/landing.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="landing">
    <section class="hero-space" id="inicio">
        <div class="hero-inner">
            <div class="hero-copy">
                <span class="badge"><?= esc(lang('Landing.hero.badge')) ?></span>
                <h1><?= esc(lang('Landing.hero.titleA')) ?><br><span class="accent"><?= esc(lang('Landing.hero.titleB')) ?></span></h1>
                <p><?= esc(lang('Landing.hero.lead')) ?></p>
                <div class="hero-ctas">
                    <a class="btn" href="/register"><?= esc(lang('Landing.hero.ctaPrimary')) ?></a>
                    <a class="btn secondary" href="/login"><?= esc(lang('Landing.hero.ctaSecondary')) ?></a>
                </div>
            </div>

            <div class="universe" role="img" aria-label="<?= esc(lang('Landing.hero.coreLabel')) ?>">
                <div class="core">
                    <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                        <rect x="29" y="6" width="6" height="10" rx="3" fill="#9db9f5"/>
                        <circle cx="32" cy="6" r="4" fill="#6f9dff"/>
                        <rect x="10" y="28" width="6" height="14" rx="3" fill="#9db9f5"/>
                        <rect x="48" y="28" width="6" height="14" rx="3" fill="#9db9f5"/>
                        <rect x="14" y="16" width="36" height="34" rx="11" fill="#e8f0fe"/>
                        <circle cx="25" cy="32" r="4.5" fill="#1a63e8"/>
                        <circle cx="39" cy="32" r="4.5" fill="#1a63e8"/>
                        <rect x="24" y="41" width="16" height="4" rx="2" fill="#1a63e8"/>
                    </svg>
                    <span><?= esc(lang('Landing.hero.coreLabel')) ?></span>
                </div>

                <div class="orbit orbit-1">
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M4 5h16v11H9l-5 4z"/></svg>
                        <?= esc(lang('Landing.orbit.messages')) ?></div></div></div>
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M5 4h4l2 5-3 2a12 12 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                        <?= esc(lang('Landing.orbit.calls')) ?></div></div></div>
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M12 3v12m0 0 4-4m-4 4-4-4M4 21h16"/></svg>
                        <?= esc(lang('Landing.orbit.import')) ?></div></div></div>
                </div>

                <div class="orbit orbit-2">
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M8 9l-4 3 4 3m8-6 4 3-4 3M13 5l-2 14"/></svg>
                        <?= esc(lang('Landing.orbit.api')) ?></div></div></div>
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M4 20V10m6 10V4m6 16v-8"/></svg>
                        <?= esc(lang('Landing.orbit.analysis')) ?></div></div></div>
                    <div class="node"><div class="sat"><div class="sat-inner">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6f9dff" stroke-width="2"><path d="M6 3h9l4 4v14H6zM9 12h6M9 16h6"/></svg>
                        <?= esc(lang('Landing.orbit.reports')) ?></div></div></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="maia">
        <h2><?= esc(lang('Landing.features.title')) ?></h2>
        <p class="lead"><?= esc(lang('Landing.features.lead')) ?></p>
        <div class="feat-grid">
            <article class="feat-card"><h3><?= esc(lang('Landing.feat1.title')) ?></h3><p><?= esc(lang('Landing.feat1.text')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.feat2.title')) ?></h3><p><?= esc(lang('Landing.feat2.text')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.feat3.title')) ?></h3><p><?= esc(lang('Landing.feat3.text')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.feat4.title')) ?></h3><p><?= esc(lang('Landing.feat4.text')) ?></p></article>
        </div>
    </section>

    <section class="section" id="servicios">
        <h2><?= esc(lang('Landing.services.title')) ?></h2>
        <p class="lead"><?= esc(lang('Landing.services.lead')) ?></p>
        <div class="feat-grid">
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.messages')) ?></h3><p><?= esc(lang('Landing.svc.messages')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.calls')) ?></h3><p><?= esc(lang('Landing.svc.calls')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.import')) ?></h3><p><?= esc(lang('Landing.svc.import')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.api')) ?></h3><p><?= esc(lang('Landing.svc.api')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.analysis')) ?></h3><p><?= esc(lang('Landing.svc.analysis')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.orbit.reports')) ?></h3><p><?= esc(lang('Landing.svc.reports')) ?></p></article>
        </div>
    </section>

    <section class="section" id="planes">
        <h2><?= esc(lang('Landing.plans.title')) ?></h2>
        <p class="lead"><?= esc(lang('Landing.plans.lead')) ?></p>
        <div class="feat-grid">
            <article class="feat-card"><h3><?= esc(lang('Landing.plan1.title')) ?></h3><p><?= esc(lang('Landing.plan1.text')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.plan2.title')) ?></h3><p><?= esc(lang('Landing.plan2.text')) ?></p></article>
            <article class="feat-card"><h3><?= esc(lang('Landing.plan3.title')) ?></h3><p><?= esc(lang('Landing.plan3.text')) ?></p></article>
        </div>
        <p class="lead plans-note"><?= esc(lang('Landing.plans.note')) ?></p>
    </section>

    <section class="section">
        <h2><?= esc(lang('Landing.steps.title')) ?></h2>
        <div class="steps-grid">
            <article class="step-card"><h3><?= esc(lang('Landing.step1.title')) ?></h3><p><?= esc(lang('Landing.step1.text')) ?></p></article>
            <article class="step-card"><h3><?= esc(lang('Landing.step2.title')) ?></h3><p><?= esc(lang('Landing.step2.text')) ?></p></article>
            <article class="step-card"><h3><?= esc(lang('Landing.step3.title')) ?></h3><p><?= esc(lang('Landing.step3.text')) ?></p></article>
            <article class="step-card"><h3><?= esc(lang('Landing.step4.title')) ?></h3><p><?= esc(lang('Landing.step4.text')) ?></p></article>
        </div>
    </section>

    <section class="section">
        <div class="cta-box">
            <div>
                <h2><?= esc(lang('Landing.cta.title')) ?></h2>
                <p><?= esc(lang('Landing.cta.text')) ?></p>
            </div>
            <a class="btn" href="/register"><?= esc(lang('Landing.hero.ctaPrimary')) ?></a>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
