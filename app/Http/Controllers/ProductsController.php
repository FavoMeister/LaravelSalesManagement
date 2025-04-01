<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
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
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }


    public function generateCode($category_id)
    {
        //try {
            $product = Products::where('category_id', $category_id)
                                ->orderBy('id', 'desc')
                                ->get();
                                //->firstOrFail();
            
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        
        //} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún producto para la categoría especificada',
                'product' => null
            ], 404);
        //}
    }
}
