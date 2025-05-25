<?php

namespace App\Http\Controllers\API\settings;


use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{

    public function index() : JsonResponse {

        $users = User::all();
        return $this->sendResponse($users);
    }


    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): JsonResponse
    {

    // PermissionHelper::authorize('user.create', 'Usuario');

        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'trade_name' => 'required|email',
            'document_number' => 'required|string',
            'address' => 'required|string',
            'phone' => 'string|min:1|nullable',
            'email' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'id_ubigeo' => 'integer|min:1|nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

       // $input['status'] = 'ACTIVO';

        $input['password'] = bcrypt($input['password']);

        $company = Company::create($input);

        return $this->sendResponse($company, 'User register successfully.');
    }

    public function edit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|exists:company,id',
            'business_name' => 'required|string|max:255',
            'trade_name' => 'required|email',
            'document_number' => 'required|string',
            'address' => 'required|string',
            'phone' => 'string|min:1|nullable',
            'email' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'id_ubigeo' => 'integer|min:1|nullable',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error  de validaciones.', $validator->errors());
        }

        $company = Company::find($request->id);

        $company->business_name    = $request->business_name;
        $company->trade_name       = $request->trade_name;
        $company->document_number  = $request->document_number;
        $company->address          = $request->address;
        $company->phone            = $request->phone;
        $company->email            = $request->email;
        $company->id_ubigeo        = $request->id_ubigeo;

        $company->save();


        return $this->sendResponse($company, 'Empresa actualizado corrctamente.');
    }



  /*  public function uniqueUser(int $id_user) : JsonResponse {
        $user = User::find($id_user);
        return  $this->sendResponse($user);
    }
*/

 /*   public function changeStatus(int $id_user): JsonResponse
    {

        $user = User::find($id_user);

        $user->status = $user->status === 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';

        $user->save();

       return $this->sendResponse($user, 'Guardado correctamente.');
    }

*/


}




