<?php

namespace App\Http\Controllers\API\settings;

use App\Http\Controllers\API\BaseController;
use App\Models\Role;
use App\Models\Role_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class RoleController extends BaseController
{
    public  function index(){

        $response = Role::all();
 foreach ($response as $rol) {
        $rol->role_details = Role_permission::where('id_role', $rol->id)->get();
        
    }

        return response()->json($response);

    }
    public function save(Request $request)
    {
        $request->validate([
            'rol' => 'required|string',
            'fl_no_dashboard' => 'nullable',
            'permisos' => 'required|json',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'name' => $request->rol,
                'fl_no_view_dashboard' => $request->boolean('fl_no_dashboard', false),
            ];

            // Si viene con ID, es edición
            if ($request->filled('id')) {
                $role = Role::findOrFail($request->id);
                $role->update($data);
            } else {
                $role = Role::create($data);
            }

            // Eliminar permisos previos
            Role_permission::where('id_role', $role->id)->delete();

            $permisos = json_decode($request->permisos);


            $data_insert = [];

            foreach ($permisos as $row) {
//                if ($row->view || $row->new || $row->edit || $row->delete) {
                    $data_insert[] = [
                        'id_role' => $role->id,
                        'menu' => $row->menu,
                        'view' => !empty($row->view) ? 1 : 0,
                        'create' => !empty($row->new) ? 1 : 0,
                        'edit' => !empty($row->edit) ? 1 : 0,
                        'delete' => !empty($row->delete) ? 1 : 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
//                }
            }

            if (!empty($data_insert)) {
                Role_permission::insert($data_insert);
            }

            // Centinela o auditoría (puedes implementar tu propio servicio)
            // AuditLog::create([...]);

            DB::commit();
            return response()->json(['tipo' => 'success', 'mensaje' => 'Rol guardado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['tipo' => 'danger', 'mensaje' => $th->getMessage()], 400);
        }
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
