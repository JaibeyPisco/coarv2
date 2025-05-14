<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\EmpresaModel;
use App\Models\Configuracion\StaticSystemModel;
use Illuminate\Support\Facades\Auth;

class AppController extends BaseController{

	
    public function initial($response = true)
	{
		
		$usuario = Auth::user();
		// $Ajuste_avanzado_m = new Ajuste_avanzado_model();
		// $empresa = new EmpresaModel();
		// $static_system = new StaticSystemModel();

		// $static_system = $static_system::first();
		// $empresa = $empresa::first();
		$permisos = [];

		if ($usuario->tipo == 'ADMINISTRADOR' or $usuario->tipo == 'SUPER ADMINISTRADOR') {

			$permisos = array(
				0 => (object) array(
				'modulo'    => '',
				'view'      => 1,
				'new'       => 1,
				'edit'      => 1,
				'delete'    => 1,
				)
			);

			$all_permiso = true;
		}
		else
		{
			$all_permiso = false;
		}


        if(is_object($usuario)){
            $response = [
				'usuario' 			=> $usuario,
				'permisos'			=> $permisos,
				// 'all_permiso'		=> $all_permiso,
				// 'empresa'			=> $empresa,
			 
			];

			
            return response()->json($response, 200);
        }	
	}
}