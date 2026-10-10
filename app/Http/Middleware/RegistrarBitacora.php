<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BitacoraAccion;

class RegistrarBitacora
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Ignorar métodos GET
        if ($request->isMethod('GET') || $request->isMethod('HEAD') || $request->isMethod('OPTIONS')) {
            return $response;
        }

        // Ignorar rutas que no queremos registrar (login, logout, assets, etc.)
        if ($request->is('login', 'logout', 'css/*', 'js/*', 'images/*', 'build/*')) {
            return $response;
        }

        try {
            $method = $request->method();
            $accion = 'Otra';

            if ($method === 'POST') {
                $accion = 'Crear';
            } elseif ($method === 'PUT' || $method === 'PATCH') {
                $accion = 'Editar';
            } elseif ($method === 'DELETE') {
                $accion = 'Eliminar';
            }

            $tablaAfectada = $request->segment(1);

            // Reemplazar guiones si es necesario
            if ($tablaAfectada === 'hoja-despacho') {
                $tablaAfectada = 'hoja_despacho';
            }

            if (!$tablaAfectada) {
                $tablaAfectada = 'sistema';
            }

            BitacoraAccion::create([
                'id_usuario' => auth()->id(), // puede ser null
                'accion' => $accion,
                'tabla_afectada' => $tablaAfectada,
                'fecha_hora' => now(),
                'ip_acceso' => $request->ip() ?? '0.0.0.0',
            ]);
        } catch (\Exception $e) {
            // No romper la aplicación si falla la bitácora
        }

        return $response;
    }
}
