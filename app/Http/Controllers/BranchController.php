<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
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
        //$branches = Branch::orderBy('id', 'desc');
        $branches = Branch::all();
        //dd($branches);
                //->where('roles.id','!=',1)
                //->paginate(10);

        return view('modules.users.branches')->with([
            'branches' => $branches,
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
        //dd($request);
        $branch = new Branch($request->all());
        //$branch->city_id = $request->city_id;
        //$enterprise=session('company');
        //$branch->company_id=$enterprise->id;
        $branch->save();
        return redirect('branches')->with('success', 'La sucursal a sido agregada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Branch $request, $id)
    {   
        $branch = Branch::find($id);
        //$caracteristics = Characteristic::where('id',$id)->where('status',1)->orderBy('number_order','asc')->get();
        //dd($caracteristic->nombre_completo);
        /* $fields=FieldType::where('status', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('name', 'id'); */
        //dd($caracteristic->name);
        //dd($caracteristic->pluck('nombre_completo','id'));
        //dd($caracteristic->lista);
        
        if($branch != null){
            //if($request->ajax()){
                return response()->json([
                    'id' => $branch->id,
                    'branch' => $branch,
                ]);
            /*}else{
                return redirect()
                    ->route('index');
            }*/
            /*return view('characteristic.edit')
                ->with([
                    'branch' => $branch,
                    //'caracterisiticas' => $caracteristics,
                    //'fields' => $fields,
                    //'FieldlId' => $caracteristic->field_type_id,
                ]);*/
        }else{
            /*flash('No se ha encontrado el registro en la base de datos. Intenta nuevamente.')
                ->error()
                ->important();*/

            return redirect()
                ->route('index');
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request);
        $branch = Branch::find($request->id);
        if ($branch != null) {
            $branch->fill($request->all());
            $branch->update();
            return redirect('branches')->with('success', 'La sucursal ha sido actualizada correctamente');
        } else {
            return redirect('index');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }

    public function changeStatus($branch_id)
    {
        $branch = Branch::find($branch_id);
        if ($branch != null) {
            $branch->status = $branch->status == 1 ? 0 : 1;
            $branch->update();
            return redirect('branches')->with('success', 'El estado de la sucursal ha sido actualizada correctamente');
        } else {
            return redirect('index');
        }
        
    }
}
