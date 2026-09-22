<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Restringe rutas por rol de membresía. Uso en rutas: ['filter' => 'role:admin,editor'].
 * Sin sesión delega a auth; con rol insuficiente responde 403.
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login');
        }

        if ($arguments !== null && $arguments !== []) {
            $role = session('role');
            if (! in_array($role, $arguments, true)) {
                return service('response')
                    ->setStatusCode(403)
                    ->setBody(esc(lang('Errors.FORBIDDEN')));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}
