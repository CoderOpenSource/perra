<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MantenimientoApiController extends Controller
{
    // Obtener todos los mantenimientos
    public function index(): JsonResponse
    {
        try {
            $mantenimientos = Mantenimiento::all();

            return response()->json([
                'mensaje' => 'Mantenimientos obtenidos correctamente',
                'data' => $mantenimientos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los mantenimientos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener un mantenimiento específico por ID
    public function show($id): JsonResponse
    {
        try {
            $mantenimiento = Mantenimiento::findOrFail($id);

            return response()->json([
                'mensaje' => 'Mantenimiento obtenido correctamente',
                'data' => $mantenimiento,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el mantenimiento',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear un nuevo mantenimiento
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'problema' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'tiempo' => 'required|string|max:255',
            'costo' => 'required|numeric',
            'id_activo' => 'required|integer|exists:activosfijo,id',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'fecha_aprox' => 'nullable|date',
            'solucion' => 'nullable|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        try {
            $mantenimiento = Mantenimiento::create($validatedData);

            return response()->json([
                'mensaje' => 'Mantenimiento creado exitosamente',
                'data' => $mantenimiento,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el mantenimiento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar un mantenimiento existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'problema' => 'string|max:255',
            'proveedor' => 'string|max:255',
            'tiempo' => 'string|max:255',
            'costo' => 'numeric',
            'id_activo' => 'integer|exists:activosfijo,id',
            'fecha_ini' => 'date',
            'fecha_fin' => 'nullable|date',
            'fecha_aprox' => 'nullable|date',
            'solucion' => 'nullable|string|max:255',
            'estado' => 'string|max:255',
        ]);

        try {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $mantenimiento->update($validatedData);

            return response()->json([
                'mensaje' => 'Mantenimiento actualizado exitosamente',
                'data' => $mantenimiento,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el mantenimiento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar un mantenimiento por ID
    public function destroy($id): JsonResponse
    {
        try {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $mantenimiento->delete();

            return response()->json([
                'mensaje' => 'Mantenimiento eliminado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar el mantenimiento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
