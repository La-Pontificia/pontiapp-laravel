<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class SanctumController extends Controller
{

    public function csrfCookie()
    {
        return response()->json(['message' => 'CSRF cookie set'])
            ->cookie(
                config('sanctum.cookie'),  // Nombre del cookie (por defecto 'XSRF-TOKEN')
                csrf_token(),              // Valor del cookie (el token CSRF generado)
                60,                        // Tiempo de expiración en minutos (ajusta según necesites)
                null,                      // Ruta donde el cookie es válido (por defecto '/' se aplica a todo)
                null,                      // Dominio (por defecto se usa el dominio actual)
                false,                     // Indica si el cookie es seguro (solo sobre HTTPS)
                true                       // Habilitar HttpOnly (se recomienda)
            );
    }
}
