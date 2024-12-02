<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
class FacturaApiController extends Controller
{
    // Listar todas las facturas
    public function index(): JsonResponse
    {
        try {
            $facturas = Factura::all();

            return response()->json([
                'mensaje' => 'Facturas obtenidas correctamente',
                'data' => $facturas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las facturas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener una factura específica por ID
    public function show($id): JsonResponse
    {
        try {
            $factura = Factura::findOrFail($id);

            return response()->json([
                'mensaje' => 'Factura obtenida correctamente',
                'data' => $factura,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la factura',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'tipo' => 'required|string|max:255',
            'vendedor' => 'nullable|string|max:255',
            'idvendedor' => 'nullable|integer|exists:users,id',
            'comprador' => 'nullable|string|max:255',
            'idcomprador' => 'nullable|integer|exists:users,id',
            'nit' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'formapago' => 'required|string|max:255',
            'fechaemitida' => 'required|date',
            'totaliva' => 'nullable|numeric',
            'iva' => 'nullable|numeric',
            'totalneto' => 'nullable|numeric',
            'referencia' => 'nullable|string|max:255',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        try {
            if ($request->tipo === 'compra') {
                $validatedData['vendedor'] = null;
                $validatedData['idvendedor'] = null;
            } elseif ($request->tipo === 'venta') {
                $validatedData['comprador'] = null;
                $validatedData['idcomprador'] = null;
            }

            // Subir foto si existe
            if ($request->hasFile('foto')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('foto')->getRealPath())->getSecurePath();
                $validatedData['foto'] = $uploadedFileUrl;
            }

            $factura = Factura::create($validatedData);

            return response()->json([
                'mensaje' => 'Factura creada exitosamente',
                'data' => $factura,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la factura',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'tipo' => 'string|max:255',
            'vendedor' => 'nullable|string|max:255',
            'idvendedor' => 'nullable|integer|exists:users,id',
            'comprador' => 'nullable|string|max:255',
            'idcomprador' => 'nullable|integer|exists:users,id',
            'nit' => 'string|max:255',
            'ciudad' => 'string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'string|max:255',
            'email' => 'nullable|string|email|max:255',
            'formapago' => 'string|max:255',
            'fechaemitida' => 'date',
            'totaliva' => 'nullable|numeric',
            'iva' => 'nullable|numeric',
            'totalneto' => 'nullable|numeric',
            'referencia' => 'nullable|string|max:255',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        try {
            $factura = Factura::findOrFail($id);

            if ($request->tipo === 'compra') {
                $validatedData['vendedor'] = null;
                $validatedData['idvendedor'] = null;
            } elseif ($request->tipo === 'venta') {
                $validatedData['comprador'] = null;
                $validatedData['idcomprador'] = null;
            }

            // Subir foto si existe
            if ($request->hasFile('foto')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('foto')->getRealPath())->getSecurePath();
                $validatedData['foto'] = $uploadedFileUrl;
            }

            $factura->update($validatedData);

            return response()->json([
                'mensaje' => 'Factura actualizada exitosamente',
                'data' => $factura,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la factura',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar una factura por ID
    public function destroy($id): JsonResponse
    {
        try {
            // Buscar la factura por ID
            $factura = Factura::findOrFail($id);

            // Eliminar la factura
            $factura->delete();

            return response()->json([
                'mensaje' => 'Factura eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la factura',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
