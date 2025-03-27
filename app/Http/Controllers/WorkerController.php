<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Exception;

class WorkerController extends Controller
{
    // Obtener todos los workers
    public function index()
    {
        try {
            $response = Http::get('http://localhost:8080/Admin'); 

            if ($response->successful()) {
                return response()->json($response->json()); 
            } else {
                return response()->json(['error' => 'Error al obtener los trabajadores.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Obtener un worker por ID para editarlo
    public function edit($id)
    {
        try {
            $response = Http::get("http://localhost:8000/Admin/edit/{$id}"); // URL de tu API local

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Error al obtener el trabajador.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Actualizar un worker por ID
    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "name" => "required|min:4|max:50",
                "email" => "required|email|max:100",
                "position" => "required|min:4|max:50",
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), 400);
            }

            $data = $request->only(['name', 'email', 'position']); // Datos para actualizar

            $response = Http::put("http://localhost:8000/Admin/update/{$id}", $data); // URL de tu API local

            if ($response->successful()) {
                return response()->json(['message' => 'Trabajador actualizado con éxito']);
            } else {
                return response()->json(['error' => 'Error al actualizar el trabajador.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Crear un nuevo worker
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "name" => "required|min:4|max:50",
                "email" => "required|email|max:100",
                "position" => "required|min:4|max:50",
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), 400);
            }

            $data = $request->only(['name', 'email', 'position']); // Datos para crear

            $response = Http::post('http://localhost:8000/Admin/create', $data); // URL de tu API local

            if ($response->successful()) {
                return response()->json(['message' => 'Trabajador creado con éxito'], 201);
            } else {
                return response()->json(['error' => 'Error al crear el trabajador.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostrar un worker por ID
    public function show($id)
    {
        try {
            $response = Http::get("http://localhost:8000/Admin/show/{$id}"); // URL de tu API local

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Error al obtener el trabajador.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Eliminar un worker por ID
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:8000/Admin/delete/{$id}"); // URL de tu API local

            if ($response->successful()) {
                return response()->json(['message' => 'Trabajador eliminado con éxito']);
            } else {
                return response()->json(['error' => 'Error al eliminar el trabajador.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}


