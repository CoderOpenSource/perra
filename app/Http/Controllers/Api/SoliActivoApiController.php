<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SoliActivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SoliActivoApiController extends Controller
{
    // Obtener todos los registros de activos
    public function index(): JsonResponse
    {
        try {
            $soliActivos = SoliActivo::with('solicitud')->get(); // Incluye la solicitud asociada

            return response()->json([
                'mensaje' => 'Activos obtenidos correctamente',
                'data' => $soliActivos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los activos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener un activo específico por ID
    public function show($id): JsonResponse
    {
        try {
            $soliActivo = SoliActivo::with('solicitud')->findOrFail($id);

            return response()->json([
                'mensaje' => 'Activo obtenido correctamente',
                'data' => $soliActivo,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el activo',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Crear un nuevo registro de activo
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'item' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'id_sol' => 'required|integer|exists:solicitud,id',
        ]);

        try {
            $soliActivo = SoliActivo::create($validatedData);

            return response()->json([
                'mensaje' => 'Activo creado exitosamente',
                'data' => $soliActivo,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el activo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar un activo existente
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'item' => 'string|max:255',
            'unidad' => 'string|max:255',
            'cantidad' => 'integer',
            'id_sol' => 'integer|exists:solicitud,id',
        ]);

        try {
            $soliActivo = SoliActivo::findOrFail($id);
            $soliActivo->update($validatedData);

            return response()->json([
                'mensaje' => 'Activo actualizado exitosamente',
                'data' => $soliActivo,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el activo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar un activo por ID
    public function destroy($id): JsonResponse
    {
        try {
            $soliActivo = SoliActivo::findOrFail($id);
            $soliActivo->delete();

            return response()->json([
                'mensaje' => 'Activo eliminado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar el activo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // Obtener los SoliActivo de una solicitud específica por id_sol
    public function getBySolicitudId($id_sol): JsonResponse
    {
        try {
            $soliActivos = SoliActivo::where('id_sol', $id_sol)->get();

            return response()->json([
                'mensaje' => 'Activos relacionados a la solicitud obtenidos correctamente',
                'data' => $soliActivos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los activos de la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
