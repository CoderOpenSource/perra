<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SolicitudApiController extends Controller
{
    // Obtener todas las solicitudes
    public function index(): JsonResponse
    {
        try {
            $solicitudes = Solicitud::all();

            return response()->json([
                'mensaje' => 'Solicitudes obtenidas correctamente',
                'data' => $solicitudes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las solicitudes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener una solicitud específica por ID
    public function show($id): JsonResponse
    {
        try {
            $solicitud = Solicitud::findOrFail($id);

            return response()->json([
                'mensaje' => 'Solicitud obtenida correctamente',
                'data' => $solicitud,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la solicitud',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear una nueva solicitud
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'persona_sol' => 'required|string|max:255',
            'clasificacion' => 'required|string|max:255',
            'concepto' => 'required|string|max:255',
            'estado' => 'string|max:255',
            'estado_fin' => 'string|max:255',
            'respuesta_fin' => 'string|max:255',
            'fecha' => 'required|date',
        ]);

        try {
            $solicitud = Solicitud::create($validatedData);

            return response()->json([
                'mensaje' => 'Solicitud creada exitosamente',
                'data' => $solicitud,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar una solicitud existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'persona_sol' => 'string|max:255',
            'clasificacion' => 'string|max:255',
            'concepto' => 'string|max:255',
            'estado' => 'string|max:255',
            'estado_fin' => 'string|max:255',
            'respuesta_fin' => 'string|max:255',
            'fecha' => 'date',
        ]);

        try {
            $solicitud = Solicitud::findOrFail($id);
            $solicitud->update($validatedData);

            return response()->json([
                'mensaje' => 'Solicitud actualizada exitosamente',
                'data' => $solicitud,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar una solicitud por ID
    public function destroy($id): JsonResponse
    {
        try {
            $solicitud = Solicitud::findOrFail($id);
            $solicitud->delete();

            return response()->json([
                'mensaje' => 'Solicitud eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
