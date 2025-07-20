<?php

namespace App\Http\Controllers\API\settings;

use App\Http\Controllers\API\BaseController;
use App\Models\Role;
use App\Models\Role_permission;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:role,name',
            'fl_no_view_dashboard' => 'string|nullable',
            'permissions' => 'required|array',
        ], [
            'name.unique'=> 'El rol debe ser unico'
        ]);

        // Crear el rol con un atributo extra 'modulo' (si lo manejas como campo en la tabla roles)
        $role = Role::create([
            'name' => $request->name,
            'fl_no_view_dashboard' => $request->fl_no_view_dashboard, // Asegúrate de tener esta columna en tu tabla roles
        ]);

        // Procesar permisos
        $permisos_finales = [];

        foreach ($request->permissions as $permiso) {
            $menu = $permiso['menu'];
            if (! $menu) continue;

            foreach (['view', 'create', 'edit', 'delete'] as $accion) {
                if (!empty($permiso[$accion])) {
                    $permiso_nombre = "$menu.$accion";

                    // Crear el permiso si no existe
                    Role_permission::firstOrCreate([
                        'name' => $permiso_nombre,
                       
                    ]);

                    $permisos_finales[] = $permiso_nombre;
                }
            }
        }

      

        return $this->sendResponse($permisos_finales, 'Rol creado correctamente');
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
