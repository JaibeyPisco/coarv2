<?php

namespace App\Http\Controllers\API\settings;

use App\Http\Controllers\API\BaseController;
use App\Models\Settings\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class PlaceController extends BaseController
{
    public  function index(){

        $response = Place::all();
         
        return $this->sendResponse($response);
    }

    public function destroy($id)
    {
        try {
            $place = place::findOrFail($id);
            
            // Eliminar permisos asociados
            //place_permission::where('id_place', $id)->delete();
            
            // Eliminar el rol
            $place->delete();
            
            return $this->sendResponse([], 'Rol eliminado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el rol', [$e->getMessage()]);
        }
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        // try {
            //DB::beginTransaction();

            $data = [
                'name' => $request->name,
                'description' => $request->description,
            ];
 ;
            // Si viene con ID, es edición
            if ($request->filled('id')) {
                $place = Place::findOrFail($request->id);

                $place->update($data);
            } else {
                $place = Place::create($data);
            }
            

           
            // Centinela o auditoría (puedes implementar tu propio servicio)
            // AuditLog::create([...]);
            //DB::commit();
            return response()->json([
                'tipo' => 'success', 
                'mensaje' => 'Rol guardado correctamente',
                'place_id' => $place->id
            ]);
        // } catch (\Throwable $th) {
        //     //DB::rollBack();
        //     return response()->json(['tipo' => 'danger', 'mensaje' => $th->getMessage()], 400);
        // }
    }


    public function limpiarnombre(String $nombre){

        // Convierte a minúsculas
        $nombre = strtolower($nombre);

        // Reemplaza espacios por guiones bajos
        $nombre = str_replace(' ', '_', $nombre);

        // Elimina caracteres especiales (solo letras, números y guiones bajos)
        $nombre = preg_replace('/[^a-z0-9_]/', '', $nombre);

        return $nombre;

    }
}
