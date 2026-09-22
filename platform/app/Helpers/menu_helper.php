<?php

/**
 * Resuelve los ítems de menú para el contexto actual.
 *
 * - 'public': menú público (sin autenticación).
 * - 'admin':  menú completo del administrador de empresa.
 * - 'tenant': menú de miembros filtrado por rol (editor, operator, auditor).
 *
 * Devuelve cada ítem con 'text' ya traducido según el locale activo.
 */
function menu_items(string $context, ?string $role = null): array
{
    $config = config('Menu');
    $items  = $config->{$context} ?? [];

    if ($context === 'tenant' && $role !== null) {
        $items = array_values(array_filter(
            $items,
            static fn (array $item): bool => in_array($role, $item['roles'], true)
        ));
    }

    return array_map(
        static fn (array $item): array => $item + ['text' => lang($item['label'])],
        $items
    );
}

/**
 * Menú del área privada según el rol de la sesión:
 * administrador ve el menú admin; el resto, el menú tenant filtrado.
 */
function private_menu_items(): array
{
    $role = session('role') ?? 'editor';

    return $role === 'admin'
        ? menu_items('admin')
        : menu_items('tenant', $role);
}
