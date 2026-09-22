<?php

namespace App\Controllers\Site;

use App\Controllers\BaseController;

/**
 * Pantallas públicas de autenticación.
 * La verificación real de credenciales es parte de T-002/T-010;
 * los POST devuelven el formulario con un aviso honesto.
 */
class Auth extends BaseController
{
    public function login()
    {
        return view('site/auth/login', ['title' => lang('Auth.login.title')]);
    }

    public function attemptLogin()
    {
        return view('site/auth/login', [
            'title'  => lang('Auth.login.title'),
            'notice' => lang('Auth.pending'),
        ]);
    }

    public function register()
    {
        return view('site/auth/register', ['title' => lang('Auth.register.title')]);
    }

    public function attemptRegister()
    {
        return view('site/auth/register', [
            'title'  => lang('Auth.register.title'),
            'notice' => lang('Auth.pending'),
        ]);
    }

    public function recovery()
    {
        return view('site/auth/recovery', ['title' => lang('Auth.recovery.title')]);
    }

    public function attemptRecovery()
    {
        return view('site/auth/recovery', [
            'title'  => lang('Auth.recovery.title'),
            'notice' => lang('Auth.pending'),
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
