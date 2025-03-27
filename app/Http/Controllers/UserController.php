<?php

namespace App\Http\Controllers;

use App\Models\client;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\worker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required|confirmed',
            "image" => "nullable|file|image|max:20000"          
        ]);

        $http = Http::baseUrl('http://localhost:8080');
        $data = $http->acceptJson();

        if ($request->hasFile('image')) {
            $data->attach(
                'image',
                file_get_contents($request->image->getPathname()),  
                $request->image->getClientOriginalName()  
            );
        }

        $response = $data->post('api/client/save',[
           'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'client',  
        ]); 
        if ($response->successful()){
        return response()->json([
            "status" => 1,
            "msg" => "¡Registro de usuario exitoso!",
        ]); 
        }else if($response->failed()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Error al conectar con la API.',
                'details' => $response->body()]);
            }
    }


    public function login(Request $request) {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = client::where("email", "=", $request->email)->first();

        if( isset($user->id) ){
            if(Hash::check($request->password, $user->password)){
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                //si está todo ok
                return response()->json([
                    "status" => 1,
                    "msg" => "¡Usuario logueado exitosamente!",
                    "access_token" => $token
                ]);        
            }else{
                return response()->json([
                    "status" => 0,
                    "msg" => "La password es incorrecta",
                ], 404);    
            }

        }else{
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado",
            ], 404);  
        }
    }

    public function userProfile() {
        return response()->json([
            "status" => 0,
            "msg" => "Acerca del perfil de usuario",
            "data" => auth()->user()
        ]); 
    }

    public function logout() {
         auth()->user()->tokens()->delete();
        
         return response()->json([
             "status" => 1,
         "msg" => "Cierre de Sesión",            
         ]); 
     }
}
