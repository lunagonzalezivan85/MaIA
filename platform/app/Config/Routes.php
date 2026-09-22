<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Área pública: solo visitantes sin sesión (guest) ─────────────────
$routes->group('', ['filter' => 'guest'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Site\Home::index');
    $routes->get('login', 'Site\Auth::login');
    $routes->post('login', 'Site\Auth::attemptLogin');
    $routes->get('register', 'Site\Auth::register');
    $routes->post('register', 'Site\Auth::attemptRegister');
    $routes->get('recovery', 'Site\Auth::recovery');
    $routes->post('recovery', 'Site\Auth::attemptRecovery');
});

// ── Área privada (admin/tenant): requiere sesión (auth) ──────────────
$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('logout', 'Site\Auth::logout');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Secciones del menú aún sin pantalla propia
    $routes->get('agents', 'Admin\Placeholder::show/agents');
    $routes->get('templates', 'Admin\Placeholder::show/templates');
    $routes->get('sources', 'Admin\Placeholder::show/sources');
    $routes->get('executions', 'Admin\Placeholder::show/executions');
    $routes->get('audit', 'Admin\Placeholder::show/audit');

    // Configuración solo para administrador
    $routes->group('settings', ['filter' => 'role:admin'], static function (RouteCollection $routes): void {
        $routes->get('/', 'Admin\Placeholder::show/settings');
        $routes->get('members', 'Admin\Placeholder::show/members');
        $routes->get('secrets', 'Admin\Placeholder::show/secrets');
    });
});
