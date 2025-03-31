<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $categories = Category::orderBy('id', 'desc')->get();
        //$categories = Category::all();
        //dd($users->first()->branch);
                //->where('roles.id','!=',1)
                //->paginate(10);

        return view('modules.products.categories')->with([
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
        $validated = $request->validate(['name' => 'required|string']);
        $category = Category::create($validated);
        //$category = new Category($request->all());
        //$branch->city_id = $request->city_id;
        //$enterprise=session('company');
        //$branch->company_id=$enterprise->id;
        //$category->save();
        return redirect('categorias')->with('success', 'La categoría a sido agregada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
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
        ]);
        
        try {
            $category = Category::findOrFail($request->id);
            $category->update($validated);
            return redirect('categorias')->with('success', 'La categoría ha sido actualizada correctamente');
        } catch (\Throwable $th) {
            return redirect('categorias')->with('error', 'No se pudo actualizar la categoría');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()
               ->route('categorias')
               ->with('success', 'Categoría eliminada correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()
               ->route('categorias')
               ->with('error', 'La categoría no existe o ya fue eliminada');
        }
    }
}
