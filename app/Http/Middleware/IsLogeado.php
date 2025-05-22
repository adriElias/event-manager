<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLogeado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //recibe los datos del header authorization
    public function handle(Request $request, Closure $next): Response
    {
        error_log('ESTOY EN EL MIDDLEWARE');
        //recuperamos el token de authorization de la petición ej.
        $token = $request->header('Authorization');

        //Si no hay token respondemos con error
        if (!$token) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        error_log('Este es token: ' . $token);
        //permitimos que la petición llegue al controller porque el/ls user esta autenticado
        return $next($request);
    }
}
