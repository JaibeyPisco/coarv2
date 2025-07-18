<?php

namespace App\Http\Controllers\API\settings;


use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'password' =>  $request->id ? 'nullable' : 'required',
            'user_type' => 'required',

          //  'c_password' => 'required|same:password',
           //'id_role' => 'required|string|exists:roles,id'
        ],[
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email',
            'password.required' => 'El campo password es obligatorio',
            'user_type.required' => 'El campo tipo de usuario es obligatorio',
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());
        }



        $input = $request->all();


        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('images', 'public');
            $urlPhoto = Storage::url($photo);
            $input['photo'] = $urlPhoto;
        }

            // $urlPhoto = Storage::url($photo);

            // $input['photo'] = $urlPhoto;

        $input['status'] = 'ACTIVO';

        $input['password'] = bcrypt($input['password']);


        if ($request->id) {
            $user = User::find($request->id);
             $user->update($input);
        } else {
            $user = User::inser($input);
        }


      //  $user->assignRole(Role::findById($request->id_role, 'api'));


        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'Usuario '.$input['name'] .' registrado correctamente .');
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




