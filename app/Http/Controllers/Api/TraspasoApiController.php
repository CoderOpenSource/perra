<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Traspaso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TraspasoApiController extends Controller
{
    // Obtener todos los traspasos
    public function index(): JsonResponse
    {
        try {
            $traspasos = Traspaso::all(); // Obtiene únicamente los traspasos

            return response()->json([
                'mensaje' => 'Traspasos obtenidos correctamente',
                'data' => $traspasos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los traspasos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // Obtener un traspaso específico por ID
    public function show($id): JsonResponse
    {
        try {
            $traspaso = Traspaso::with('activo')->findOrFail($id);

            return response()->json([
                'mensaje' => 'Traspaso obtenido correctamente',
                'data' => $traspaso,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el traspaso',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear un nuevo traspaso
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'anterior' => 'required|string|max:255',
            'nuevo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'required|string|max:255',
            'id_activo' => 'required|integer|exists:activosfijo,id',
        ]);

        try {
            $traspaso = Traspaso::create($validatedData);

            return response()->json([
                'mensaje' => 'Traspaso creado exitosamente',
                'data' => $traspaso,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el traspaso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar un traspaso existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'anterior' => 'string|max:255',
            'nuevo' => 'string|max:255',
            'fecha' => 'date',
            'descripcion' => 'string|max:255',
            'id_activo' => 'integer|exists:activosfijo,id',
        ]);

        try {
            $traspaso = Traspaso::findOrFail($id);
            $traspaso->update($validatedData);

            return response()->json([
                'mensaje' => 'Traspaso actualizado exitosamente',
                'data' => $traspaso,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el traspaso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar un traspaso por ID
    public function destroy($id): JsonResponse
    {
        try {
            $traspaso = Traspaso::findOrFail($id);
            $traspaso->delete();

            return response()->json([
                'mensaje' => 'Traspaso eliminado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar el traspaso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
