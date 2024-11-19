<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Importa la clase Controller
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DepartamentoApiController extends Controller
{
    // Método para obtener todos los departamentos
    public function index(): JsonResponse
    {
        try {
            $departamentos = Departamento::all(); // Obtiene todos los registros
            return response()->json([
                'mensaje' => 'Departamentos obtenidos correctamente',
                'data' => $departamentos
            ], 200); // Devuelve en formato JSON
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'mensaje' => 'Error al obtener los departamentos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
