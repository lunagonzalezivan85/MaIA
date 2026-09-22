<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * Secciones del área privada aún sin pantalla propia.
 * Mantiene el menú navegable mientras se construyen los módulos.
 */
class Placeholder extends BaseController
{
    public function show(string $section)
    {
        return view('admin/placeholder', [
            'title'   => $section,
            'section' => $section,
        ]);
    }
}
