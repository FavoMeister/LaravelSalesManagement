<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 'Administrator') {
            return redirect('index');
        }
        $products = Products::orderBy('id', 'desc')->get();
        $categories = Category::where('status', 1)->get();
        return view('modules.products.products')->with([
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:products,code',
            'description' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imgRoute = $request->hasFile('image') ? $request->image->store('products', 'public') : '';
        Products::create([
            ...$validated,
            'image' => $imgRoute,
            'added_date' => now(),
        ]);
        return redirect('productos')->with('success', 'El producto ha sido agregada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Products::findOrFail($id);
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                Rule::unique('products')->ignore($request->id ?? null),
            ],
            'description' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        try {
            $product = Products::findOrFail($request->id);
            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $imgRoute = $request->file('image')->store('products', 'public');
            } else {
                $imgRoute = $product->image;
            }
            $product->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['description'],
                'stock' => $validated['stock'],
                'purchase_price' => $validated['purchase_price'],
                'selling_price' => $validated['selling_price'],
                'category_id' => $validated['category_id'],
                'image' => $imgRoute,
            ]);
            return redirect('productos')->with('success', 'El producto ha sido actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect('productos')->with('error', 'No se pudo actualizar el producto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Products::findOrFail($id);
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()
               ->route('productos')
               ->with('success', 'producto eliminado correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()
               ->route('productos')
               ->with('error', 'El producto no existe o ya fue eliminado');
        }
    }


    public function generateCode($category_id)
    {
        $product = Products::where('category_id', $category_id)
                        ->orderBy('id', 'desc')
                        ->first();

        return response()->json([
            'success' => true,
            'product' => $product ? $product : [],
        ]);
        /*try {
            $product = Products::where('category_id', $category_id)
                                ->orderBy('id', 'desc')
                                //->get();
                                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún producto para la categoría especificada',
                'product' => null
            ], 404);
        }*/
    }
}
