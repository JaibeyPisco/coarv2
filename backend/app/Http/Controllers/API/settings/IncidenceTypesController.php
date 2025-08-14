<?php

namespace App\Http\Controllers\API\settings;

use App\Http\Controllers\API\BaseController;
use App\Models\Settings\IncidenceTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class IncidenceTypesController extends BaseController
{
    public  function index(){

        $response = IncidenceTypes::all();
         
        return $this->sendResponse($response);
    }

    public function destroy($id)
    {
        try {
            $incidence_type = IncidenceTypes::findOrFail($id);
            
            // Eliminar permisos asociados
            //incidence_type_permission::where('id_incidence_type', $id)->delete();
            
            // Eliminar el rol
            $incidence_type->delete();
            
            return $this->sendResponse([], 'Rol eliminado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el rol', [$e->getMessage()]);
        }
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string', 
            'level'=> 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'name' => $request->name,
                'level' => $request->level,
                'status' => 'ACTIVO',
            ];
 ;
            // Si viene con ID, es edición
            if ($request->filled('id')) {
                $incidence_type = IncidenceTypes::findOrFail($request->id);

                $incidence_type->update($data);
            } else {
                $incidence_type = IncidenceTypes::create($data);
            }
           
            return response()->json([
                'tipo' => 'success', 
                'mensaje' => 'El tipo de incidencia guardado correctamente',
                'incidence_type' => $incidence_type->id
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['tipo' => 'danger', 'mensaje' => $th->getMessage()], 400);
        }
    } 
}
