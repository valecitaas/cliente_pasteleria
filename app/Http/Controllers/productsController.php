<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Exception;

class productsController extends Controller
{
    public function index_products() {
        try {
            $response = Http::get('http://localhost:8080/api/products');

            if ($response->successful()) {
                $products = $response->json();
                return response()->json($products);
                //return view('products.list')-> with('products',$products);
            } else {
                return response()->json(['error' => 'Error al obtener los productos.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
//----------------------------------------------------------------------------------------------
    public function store(Request $request)
{
    try {
        // Validación de datos
        $validate = Validator::make($request->all(), [
            "name" => "required|min:4|max:50",
            "description" => "required|min:4|max:100",
            "price" => "required|numeric",
            "stock" => "required|numeric",
            "discount" => "required|numeric",
            "image1" => "nullable|file|image|max:20000",
            "image2" => "nullable|file|image|max:20000",
            "image3" => "nullable|file|image|max:20000",
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $http = Http::baseUrl('http://localhost:8080'); 

        $data = $http->acceptJson();
        
        
        if ($request->hasFile('image1')) {
            $data->attach(
                'image1',  
                file_get_contents($request->image1->getPathname()),  
                $request->image1->getClientOriginalName()  
            );
        }
            if ($request->hasFile('image2')) {
                $data->attach(
                    'image2',  // Nombre del campo en el formulario
                    file_get_contents($request->image2->getPathname()),  
                    $request->image1->getClientOriginalName()  
                );
        }
                if ($request->hasFile('image3')) {
                    $data->attach(
                        'image3',  // Nombre del campo en el formulario
                        file_get_contents($request->image3->getPathname()),  
                        $request->image1->getClientOriginalName()  
                    );
        }

        $response = $data->post('api/products/save', [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
            
        ]);

        if ($response->successful()) {
            return response()->json( ['message' => 'Producto creado con exito'], 201);
        } else {
            return response()->json(['error' => 'Error al crear el producto.'], 400);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
//---------------------------------------------------------------------------------------------------------------
public function update(Request $request, $id)
{
    //dd($request->all());
    try {
        // Validación de datos
        $validate = Validator::make($request->all(), [
            "name" => "required|min:4|max:50",
            "description" => "required|min:4|max:100",
            "price" => "required|numeric",
            "stock" => "required|numeric",
            "discount" => "required|numeric",
        
            "image1" => "nullable|file|image|max:20000",
            "image2" => "nullable|file|image|max:20000",
            "image3" => "nullable|file|image|max:20000",
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $http = Http::baseUrl('http://localhost:8080'); 

        $data = $http->acceptJson();

        if ($request->hasFile('image1')) {
            $data->attach(
                'image1',  
                file_get_contents($request->image1->getPathname()),  
                $request->image1->getClientOriginalName()  
            );
        }
        if ($request->hasFile('image2')) {
            $data->attach(
                'image2',  
                file_get_contents($request->image2->getPathname()),  
                $request->image2->getClientOriginalName()  
            );
    }
            if ($request->hasFile('image3')) {
                $data->attach(
                    'image3',  
                    file_get_contents($request->image3->getPathname()),  
                    $request->image3->getClientOriginalName()  
                );
    }
        
        $response = $data->post("api/products/update/{$id}", [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
        
            '_method' => 'PUT',
        ]);
        //dd($data->asJson());
        if ($response->successful()) {
            return response()->json(['message' => 'Producto actualizado con exito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar el producto.'], 400);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
//----------------------------------------------------------------------------------------------------------

    public function destroy($id) {
        try {
            $response = Http::delete("http://localhost:8080/api/products/delete/{$id}");

            if ($response->successful()) {
                return response()->json(['message' => 'Producto desactivado con éxito'], 200);
            } else {
                return response()->json(['error' => 'Error al desactivar el producto.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id) {
        try {
            $response = Http::get("http://localhost:8080/api/products/show/{$id}");
    
            if ($response->successful()){
                $product = $response->json();
                    return view('products.mostrar')->with('product',$product);
            }else {
                    return response()->json(['error' => 'Error al obtener el producto.'], 400);
                }
                
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


public function edit($id) {
    try {
        $response = Http::get("http://localhost:8080/api/products/edit/{$id}");

        if ($response->successful()){
            $product = $response->json();
                return view('products.editar')->with('product',$product);
        }else {
                return response()->json(['error' => 'Error al obtener los productos.'], 400);
            }
            
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
