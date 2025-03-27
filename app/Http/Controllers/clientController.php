<?php

namespace App\Http\Controllers;

use App\Models\client;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class clientController extends Controller
{
    
    public function index() {
        try {
            
            $response = Http::get('http://localhost:8080/api/clients'); 

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            } else {
                return response()->json(['error' => 'No se pudo obtener los clientes'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) {
        try {
            // Validar los datos de entrada
            $validate = Validator::make($request->all(), [
                "name" => "required|min:4|max:50",
                "lastname" => "required|min:4|max:50",
                "email" => "required|email|min:6|max:50",
                "social_media" => "required|min:4|max:50",
                "password" => "required|min:4|max:80",
                "image" => "nullable|file|image|max:20000", 
            ])->validate();

            $http = Http::baseUrl('http://localhost:8080');
            $data = $http->acceptJson();

            if ($request->hasFile('image')) {
                $data->attach(
                    'image',
                    file_get_contents($request->image1->getPathname()),  
                    $request->image->getClientOriginalName()  
                );
            }

            $response = $data->post('api/clients/save',[
               'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role ?? 'user',  
            ]); 

            if ($response->successful()) {
                return response()->json(['message' => 'Cliente creado con éxito'], 201);
            } else {
                return response()->json(['error' => 'No se pudo crear el cliente'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            
            $response = Http::get("http://localhost:8080/api/clients/show/{$id}");

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            } else {
                return response()->json(['error' => 'Cliente no encontrado'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {//dd($request->all());

            $request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                "password" => "required|min:8|max:80",
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

            $response = $data->post('api/clients/update/'.$id,[
               'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'client',
                'method' => 'PUT',  
            ]); 

            if ($response->successful()) {
                return response()->json(['message' => 'Cliente actualizado con exito'], 201);
            } else {
                return response()->json(['error' => 'No se pudo actualizar el cliente'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function destroy($id) {
        try {
            
            $response = Http::delete("http://localhost:8080/api/clients/delete/{$id}"); 

            if ($response->successful()) {
                return response()->json(['message' => 'Cliente eliminado con éxito'], 200);
            } else {
                return response()->json(['error' => 'No se pudo eliminar el cliente'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
