<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UbicacionApiController extends Controller
{
    // App\Http\Controllers\Api\UbicacionApiController.php

    public function index(): JsonResponse
    {
        try {
            // Obtener todas las ubicaciones junto con el departamento asociado
            $ubicaciones = Ubicacion::with('departamento')->get();

            // Transformar los datos para incluir el nombre del departamento en cada ubicación
            $ubicacionesConDepartamento = $ubicaciones->map(function ($ubicacion) {
                return [
                    'id' => $ubicacion->id,
                    'edificio' => $ubicacion->edificio,
                    'ciudad' => $ubicacion->ciudad,
                    'pais' => $ubicacion->pais,
                    'departamento' => [
                        'id' => $ubicacion->departamento->id,
                        'nombre' => $ubicacion->departamento->nombre,
                    ]
                ];
            });

            return response()->json([
                'mensaje' => 'Ubicaciones obtenidas correctamente',
                'data' => $ubicacionesConDepartamento
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las ubicaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Método para obtener una ubicación específica por ID
    public function show($id): JsonResponse
    {
        try {
            $ubicacion = Ubicacion::findOrFail($id);
            return response()->json([
                'mensaje' => 'Ubicación obtenida correctamente',
                'data' => $ubicacion
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la ubicación',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // Método para crear una nueva ubicación
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'edificio' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'id_departamento' => 'required|integer|exists:departamentos,id'
        ]);

        try {
            $ubicacion = Ubicacion::create($request->all());
            return response()->json([
                'mensaje' => 'Ubicación creada exitosamente',
                'data' => $ubicacion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para actualizar una ubicación existente
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'edificio' => 'string|max:255',
            'ciudad' => 'string|max:255',
            'pais' => 'string|max:255',
            'id_departamento' => 'integer|exists:departamentos,id'
        ]);

        try {
            $ubicacion = Ubicacion::findOrFail($id);
            $ubicacion->update($request->all());
            return response()->json([
                'mensaje' => 'Ubicación actualizada exitosamente',
                'data' => $ubicacion
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para eliminar una ubicación
    public function destroy($id): JsonResponse
    {
        try {
            $ubicacion = Ubicacion::findOrFail($id);
            $ubicacion->delete();
            return response()->json([
                'mensaje' => 'Ubicación eliminada correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
