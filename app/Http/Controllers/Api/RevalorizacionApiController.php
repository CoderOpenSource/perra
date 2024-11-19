<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Revalorizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevalorizacionApiController extends Controller
{
    // Método para obtener todas las revalorizaciones
    public function index()
    {
        try {
            // Obtener todas las revalorizaciones de la tabla 'revalorizaciones'
            $revalorizaciones = Revalorizacion::all();

            // Retornar las revalorizaciones en formato JSON
            return response()->json([
                'mensaje' => 'Datos obtenidos correctamente',
                'data' => $revalorizaciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los datos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para crear una nueva revalorización
    public function crearRevalorizacion(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'id_activo' => 'required|integer',
            'tiempo_vida' => 'required|integer',
            'valor' => 'required|numeric',
            'estado' => 'required|string',
            'costo_revaluo' => 'required|numeric',
            'created_at' => 'nullable|date'
        ]);

        try {
            // Crear la nueva revalorización
            $revalorizacion = Revalorizacion::create([
                'id_activo' => $validatedData['id_activo'],
                'tiempo_vida' => $validatedData['tiempo_vida'],
                'valor' => $validatedData['valor'],
                'estado' => $validatedData['estado'],
                'costo_revaluo' => $validatedData['costo_revaluo'],
                'created_at' => $validatedData['created_at'] ?? now(), // Si no se envía, usar la fecha actual
            ]);

            return response()->json([
                'mensaje' => 'Revalorización creada exitosamente',
                'data' => $revalorizacion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la revalorización',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para editar una revalorización existente
    public function editarRevalorizacion(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'id_activo' => 'required|integer',
            'tiempo_vida' => 'required|integer',
            'valor' => 'required|numeric',
            'estado' => 'required|string',
            'costo_revaluo' => 'required|numeric',
        ]);

        try {
            // Buscar la revalorización por ID
            $revalorizacion = Revalorizacion::find($id);

            if (!$revalorizacion) {
                return response()->json(['mensaje' => 'Revalorización no encontrada'], 404);
            }

            // Actualizar los datos de la revalorización
            $revalorizacion->update([
                'id_activo' => $validatedData['id_activo'],
                'tiempo_vida' => $validatedData['tiempo_vida'],
                'valor' => $validatedData['valor'],
                'estado' => $validatedData['estado'],
                'costo_revaluo' => $validatedData['costo_revaluo'],
            ]);

            return response()->json([
                'mensaje' => 'Revalorización actualizada exitosamente',
                'data' => $revalorizacion
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la revalorización',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para eliminar una revalorización usando el ID
    public function eliminarRevalorizacion($id)
    {
        try {
            // Buscar la revalorización por ID
            $revalorizacion = Revalorizacion::find($id);

            if (!$revalorizacion) {
                return response()->json(['mensaje' => 'Revalorización no encontrada'], 404);
            }

            // Eliminar la revalorización
            $revalorizacion->delete();

            return response()->json(['mensaje' => 'Revalorización eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la revalorización',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
