<?php

namespace App\Http\Controllers\API\settings;


use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
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
    public function register(Request $request): JsonResponse
    {

    // PermissionHelper::authorize('user.create', 'Usuario');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role' => 'required|string|exists:roles,name'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $input['status'] = 'ACTIVO';

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);


        $user->assignRole(Role::findByName($request->role, 'api'));


        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function edit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|exists:users,id',
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $request->id,
            'role'     => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::find($request->id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        // Reasignar el rol
        $user->syncRoles([Role::findByName($request->role, 'api')]);

        return $this->sendResponse($user, 'Usuario actualizado corrctamente.');
    }



    public function uniqueUser(int $id_user) : JsonResponse {
        $user = User::find($id_user);
        return  $this->sendResponse($user);
    }


    public function changeStatus(int $id_user): JsonResponse
    {

        $user = User::find($id_user);

        $user->status = $user->status === 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';

        $user->save();

       return $this->sendResponse($user, 'Guardado correctamente.');
    }




}




