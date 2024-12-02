<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Depreciacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepreciacionApiController extends Controller
{
    // Obtener todas las depreciaciones
    public function index(): JsonResponse
    {
        try {
            $depreciaciones = Depreciacion::all();

            return response()->json([
                'mensaje' => 'Depreciaciones obtenidas correctamente',
                'data' => $depreciaciones,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las depreciaciones',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener una depreciación específica por ID
    public function show($id): JsonResponse
    {
        try {
            $depreciacion = Depreciacion::findOrFail($id);

            return response()->json([
                'mensaje' => 'Depreciación obtenida correctamente',
                'data' => $depreciacion,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la depreciación',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear una nueva depreciación
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'año' => 'required|integer',
            'valor' => 'required|numeric',
            'd_acumulada' => 'required|numeric',
            'id_activo' => 'required|integer|exists:activosfijo,id',
        ]);

        try {
            $depreciacion = Depreciacion::create($validatedData);

            return response()->json([
                'mensaje' => 'Depreciación creada exitosamente',
                'data' => $depreciacion,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la depreciación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar una depreciación existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'año' => 'integer',
            'valor' => 'numeric',
            'd_acumulada' => 'numeric',
            'id_activo' => 'integer|exists:activosfijo,id',
        ]);

        try {
            $depreciacion = Depreciacion::findOrFail($id);
            $depreciacion->update($validatedData);

            return response()->json([
                'mensaje' => 'Depreciación actualizada exitosamente',
                'data' => $depreciacion,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la depreciación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar una depreciación por ID
    public function destroy($id): JsonResponse
    {
        try {
            $depreciacion = Depreciacion::findOrFail($id);
            $depreciacion->delete();

            return response()->json([
                'mensaje' => 'Depreciación eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la depreciación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
