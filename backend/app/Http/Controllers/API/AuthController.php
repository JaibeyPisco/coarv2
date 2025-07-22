<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    // public function register(Request $request): JsonResponse
    // {

    //     // PermissionHelper::authorize('user.create', 'Usuario');

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'c_password' => 'required|same:password',
    //         'role' => 'required|string|exists:roles,name'
    //     ]);

    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }

    //     $input = $request->all();

    //     $input['status'] = 'ACTIVO';

    //     $input['password'] = bcrypt($input['password']);

    //     $user = User::create($input);


    //     $user->assignRole(Role::findByName($request->role, 'api'));


    //     $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    //     $success['name'] =  $user->name;

    //     return $this->sendResponse($success, 'User register successfully.');
    // }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {

       
        $isAuthed  = Auth::attempt(
            [
                'email' =>'jpisco@coarms.com',
                'password' => 'password'
            ]);
        // $isAuthed  = Auth::attempt(
        //     [
        //         'email' => $request->email,
        //         'password' => $request->password
        //     ]);


 
        if($isAuthed){

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'Usuario logeado correctamente.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'No autorizado, Correo o contraseña incorrecto.']);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse([], 'User logged out successfully.');
    }
}
