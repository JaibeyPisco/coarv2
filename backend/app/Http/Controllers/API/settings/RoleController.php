<?php

namespace App\Http\Controllers\API\settings;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'fl_no_view_dashboard' => 'string|nullable',
            'permissions' => 'required|array',
        ]);

        // Crear el rol con un atributo extra 'modulo' (si lo manejas como campo en la tabla roles)
        $role = Role::create([
            'name' => $this->limpiarnombre($request->name),
            'fl_no_view_dashboard' => $request->fl_no_view_dashboard, // Asegúrate de tener esta columna en tu tabla roles
            'display_name' =>  $request->name,
            'guard_name' => 'api',
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
                    Permission::firstOrCreate([
                        'name' => $permiso_nombre,
                        'guard_name' => 'api',
                    ]);

                    $permisos_finales[] = $permiso_nombre;
                }
            }
        }

        $role->syncPermissions($permisos_finales);

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
