<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TablaOrigenController extends Controller
{
    public function actualizarVista()
    {
        return view('actualizar-tabla');
    }

    public function actualizar()
    {
        try {
            // Ejecutar el procedimiento almacenado
            DB::connection()->getPdo()->exec("BEGIN actualizar_tabla_destino; END;");

            // Obtener datos para comparación
            $origen = DB::table('tabla_origen')
                ->orderByDesc('fecha_creacion')
                ->limit(5)
                ->get();

            $destino = DB::table('tabla_destino')
                ->orderByDesc('fecha_creacion')
                ->limit(5)
                ->get();

            return redirect()->route('dashboard')
                ->with([
                    'success' => 'Sincronización completada exitosamente',
                    'origen' => $origen,
                    'destino' => $destino,
                    'sync_time' => now()->format('d/m/Y H:i:s')
                ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error en la sincronización: ' . $e->getMessage());
        }
    }

    public function mostrarComparacion()
    {
        $origen = DB::table('tabla_origen')
            ->orderByDesc('fecha_creacion')
            ->limit(5)
            ->get();

        $destino = DB::table('tabla_destino')
            ->orderByDesc('fecha_creacion')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'origen' => $origen,
            'destino' => $destino,
            'last_checked' => now()->format('d/m/Y H:i:s')
        ]);
    }
    public function resetTablaDestino()
    {
        DB::statement("TRUNCATE TABLE tabla_destino");
        return redirect()->route('dashboard')->with('success', 'tabla_destino fue vaciada.');
    }
}
