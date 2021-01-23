<?php

namespace App\Http\Controllers;

use App\Http\Actions\IAction;

/**
 * Se encarga de recibir un token autenticado, validarlo
 * y generar un nuevo token que no se encuentre expirado
 */
class RefreshTokenAction implements IAction
{
    /**
     * Recibimos el token por request, lo validamos
     * y, de ser correcto, le actualizamos la fecha
     * si coincide con la fecha de 
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function response(Request $request): JsonResponse
    {
        //
    }
}