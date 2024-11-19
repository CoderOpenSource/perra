<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Baja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaController extends Controller
{
    public function obtenerBajas()
    {
        try {
            //$paciente = auth('api')->user();
            $bajas = Baja::join('activosfijo', 'bajas.idactivo', 'activosfijo.id')
            ->select('bajas.id', 'activosfijo.nombre as activo', 'bajas.causadebaja', 'bajas.fechasolicitada', 'bajas.fechaaceptada', 'bajas.estado')->get();
            return response()->json(['mensaje' => 'Consulta exitosa', 'data' => $bajas], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    // Método para eliminar una Baja usando el ID
    public function eliminarBaja($id)
    {
        try {
            DB::beginTransaction();

            // Buscar la baja por ID
            $baja = Baja::find($id);

            // Verificar si la baja existe
            if (!$baja) {
                return response()->json(['mensaje' => 'Baja no encontrada'], 404);
            }

            // Eliminar la baja
            $baja->delete();

            DB::commit();
            return response()->json(['mensaje' => 'Baja eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function crearBaja(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'idactivo' => 'required|exists:activosfijo,id',  // Asegurar que el activo exista
            'causadebaja' => 'required|string',
            'fechasolicitada' => 'required|date',
            'estado' => 'required|string',
            'fechaaceptada' => 'nullable|date', // Puede ser null
        ]);

        try {
            DB::beginTransaction();

            // Crear nueva baja
            $baja = Baja::create([
                'idactivo' => $validatedData['idactivo'],
                'causadebaja' => $validatedData['causadebaja'],
                'fechasolicitada' => $validatedData['fechasolicitada'],
                'estado' => $validatedData['estado'],
                'fechaaceptada' => $validatedData['fechaaceptada'],
            ]);

            DB::commit();
            return response()->json(['mensaje' => 'Baja creada exitosamente', 'data' => $baja], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => 'Error al crear baja: ' . $e->getMessage()], 500);
        }
    }
    public function editarBaja(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'idactivo' => 'required|exists:activosfijo,id',
            'causadebaja' => 'required|string',
            'fechasolicitada' => 'required|date',
            'estado' => 'required|string',
            'fechaaceptada' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            // Buscar la baja por ID
            $baja = Baja::find($id);

            if (!$baja) {
                return response()->json(['mensaje' => 'Baja no encontrada'], 404);
            }

            // Actualizar los datos de la baja
            $baja->update([
                'idactivo' => $validatedData['idactivo'],
                'causadebaja' => $validatedData['causadebaja'],
                'fechasolicitada' => $validatedData['fechasolicitada'],
                'estado' => $validatedData['estado'],
                'fechaaceptada' => $validatedData['fechaaceptada'],
            ]);

            DB::commit();
            return response()->json(['mensaje' => 'Baja actualizada exitosamente', 'data' => $baja], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => 'Error al actualizar baja: ' . $e->getMessage()], 500);
        }
    }

}
