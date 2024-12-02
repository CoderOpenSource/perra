<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nota;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotaApiController extends Controller
{
    // Obtener todas las notas
    public function index(): JsonResponse
    {
        try {
            $notas = Nota::all(); // Obtener todas las notas
            return response()->json([
                'mensaje' => 'Notas obtenidas correctamente',
                'data' => $notas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las notas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener una nota específica por ID
    public function show($id): JsonResponse
    {
        try {
            $nota = Nota::findOrFail($id); // Buscar la nota por ID
            return response()->json([
                'mensaje' => 'Nota obtenida correctamente',
                'data' => $nota,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la nota',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear una nueva nota
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'tipo' => 'required|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|integer',
            'totales' => 'nullable|numeric',
            'fecha_entrega' => 'nullable|date',
            'foto' => 'nullable|string|max:255',
            'adquirente' => 'nullable|string|max:255',
            'fecha_venta' => 'nullable|date',
            'encargado' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
        ]);

        try {
            $nota = Nota::create($validatedData);
            return response()->json([
                'mensaje' => 'Nota creada exitosamente',
                'data' => $nota,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar una nota existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'tipo' => 'string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|integer',
            'totales' => 'nullable|numeric',
            'fecha_entrega' => 'nullable|date',
            'foto' => 'nullable|string|max:255',
            'adquirente' => 'nullable|string|max:255',
            'fecha_venta' => 'nullable|date',
            'encargado' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
        ]);

        try {
            $nota = Nota::findOrFail($id);
            $nota->update($validatedData);

            return response()->json([
                'mensaje' => 'Nota actualizada exitosamente',
                'data' => $nota,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar una nota por ID
    public function destroy($id): JsonResponse
    {
        try {
            $nota = Nota::findOrFail($id);
            $nota->delete();

            return response()->json([
                'mensaje' => 'Nota eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
