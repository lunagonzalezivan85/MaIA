<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Menús de navegación por contexto.
 *
 * - admin:  administrador de empresa (menú completo del espacio).
 * - tenant: miembros de la empresa; cada ítem declara los roles que lo ven
 *           (editor, operator, auditor). El filtrado se aplica en backend.
 * - public: visitantes sin autenticar.
 *
 * Cada ítem: label (clave lang 'Archivo.clave'), route (URI interna),
 * icon (nombre del catálogo de iconos), roles (solo menú tenant)
 * y children opcional.
 */
class Menu extends BaseConfig
{
    /**
     * Menú del administrador de empresa.
     *
     * @var list<array{label:string, route:string, icon:string}>
     */
    public array $admin = [
        ['label' => 'App.nav.dashboard',       'route' => '/dashboard',        'icon' => 'home'],
        ['label' => 'App.nav.agents',          'route' => '/agents',           'icon' => 'agent'],
        ['label' => 'App.nav.templates',       'route' => '/templates',        'icon' => 'template'],
        ['label' => 'App.nav.sources',         'route' => '/sources',          'icon' => 'database'],
        ['label' => 'App.nav.executions',      'route' => '/executions',       'icon' => 'history'],
        ['label' => 'App.nav.settings',        'route' => '/settings',         'icon' => 'settings'],
        ['label' => 'Settings.members.title',  'route' => '/settings/members', 'icon' => 'users'],
        ['label' => 'Settings.secrets.title',  'route' => '/settings/secrets', 'icon' => 'key'],
        ['label' => 'App.nav.audit',           'route' => '/audit',            'icon' => 'audit'],
    ];

    /**
     * Menú de miembros de la empresa por rol (editor, operator, auditor).
     * 'roles' lista los roles con acceso al ítem.
     *
     * @var list<array{label:string, route:string, icon:string, roles:list<string>}>
     */
    public array $tenant = [
        ['label' => 'App.nav.dashboard',  'route' => '/dashboard',  'icon' => 'home',     'roles' => ['editor', 'operator', 'auditor']],
        ['label' => 'App.nav.agents',     'route' => '/agents',     'icon' => 'agent',    'roles' => ['editor', 'operator', 'auditor']],
        ['label' => 'App.nav.templates',  'route' => '/templates',  'icon' => 'template', 'roles' => ['editor', 'auditor']],
        ['label' => 'App.nav.sources',    'route' => '/sources',    'icon' => 'database', 'roles' => ['editor', 'auditor']],
        ['label' => 'App.nav.executions', 'route' => '/executions', 'icon' => 'history',  'roles' => ['editor', 'operator', 'auditor']],
        ['label' => 'App.nav.audit',      'route' => '/audit',      'icon' => 'audit',    'roles' => ['auditor']],
    ];

    /**
     * Menú público (sin autenticación).
     *
     * @var list<array{label:string, route:string, icon:string}>
     */
    public array $public = [
        ['label' => 'Landing.nav.home',     'route' => '/#inicio',    'icon' => 'home'],
        ['label' => 'Landing.nav.maia',     'route' => '/#maia',      'icon' => 'info'],
        ['label' => 'Landing.nav.services', 'route' => '/#servicios', 'icon' => 'grid'],
        ['label' => 'Landing.nav.plans',    'route' => '/#planes',    'icon' => 'tag'],
        ['label' => 'Auth.login.title',     'route' => '/login',      'icon' => 'login'],
        ['label' => 'Auth.register.title',  'route' => '/register',   'icon' => 'user-plus'],
    ];
}
