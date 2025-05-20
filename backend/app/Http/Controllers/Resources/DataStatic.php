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
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->search;

        $results = Static_ubigeo::selectRaw("id_ubigeo, CONCAT(id_ubigeo, ' - ', departamento, ' - ', provincia, ' - ', distrito) as text")
            ->where('id_ubigeo', 'like', "%{$search}%")
            ->orWhere('departamento', 'like', "%{$search}%")
            ->orWhere('provincia', 'like', "%{$search}%")
            ->orWhere('distrito', 'like', "%{$search}%")
            ->get();

       return $this->sendResponse($results);
    }

}
