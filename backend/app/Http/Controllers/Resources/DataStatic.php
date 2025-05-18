<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\API\BaseController;

use App\Models\Static_ubigeo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataStatic extends BaseController
{
    public function ubigeo(Request $request)
    {
        $buscar = $request->query('buscar');

        //TODO: HACER QUE FUNCIONE EL FILTRO.


        $resultados = Static_ubigeo::selectRaw("id_ubigeo, CONCAT(id_ubigeo, ' - ', departamento, ' - ', provincia, ' - ', distrito) as text")
            ->where('id_ubigeo', 'like', "%{$buscar}%")
            ->orWhere('departamento', 'like', "%{$buscar}%")
            ->orWhere('provincia', 'like', "%{$buscar}%")
            ->orWhere('distrito', 'like', "%{$buscar}%")
            ->get();

       // return $this->sendResponse($resultados);
    }

}
