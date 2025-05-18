<?php namespace App\Helpers;

class PermissionHelper
{
    public static function authorize(string $permiso,string $modulo)
    {
        if (auth()->user()?->hasRole('superadmin')) {
            return;
        }

        if (!auth()->user()?->can($permiso)) {

            $tipo_permiso = explode('.', $permiso)[1] ?? 'unknown';

           $mensaje = '';

           switch ($tipo_permiso) {

            case 'view':
                $mensaje = "No tienes permiso para ver '$modulo'";
                break;
            case 'new':
                $mensaje = "No tienes permiso para crear '$modulo'";
                break;

            case 'edit':
                $mensaje = "No tienes permiso para editar '$modulo'";
                break;
            case 'delete':
                $mensaje = "No tienes permiso para eliminar '$modulo'";
                break;
            default:
                # code...
                break;
           }

            abort(response()->json([
                'error' => $mensaje .". Consulte con su administrador"
            ], 403));
        }
    }
}
