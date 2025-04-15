<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientController extends Controller
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
        //$clients = Client::orderBy('id', 'desc')->get();
        /*$clients = Client::where('clients.status', 1)->leftJoin('sales', 'sales.client_id', 'clients.id')
        ->select('clients.id', 'clients.name', 'clients.phone', 'clients.document', 'clients.direction', 'clients.status', 'clients.email', \DB::raw('MAX(sales.sale_date) as last_sale'))
        ->groupBy('clients.id', 'clients.name', 'clients.phone', 'clients.document', 'clients.direction', 'clients.status', 'clients.email')
        ->get();*/

        $clients = Client::query()
            ->active() // Scope for status = 1
            ->withLastSale() // Scope personalized
            ->withPurchaseCount()
            ->orderByDesc('id')
            ->get([
                'id',
                'name',
                'phone',
                'document',
                'direction',
                'status',
                'email'
            ]);
        
        return view('modules.clients.clients')->with([
            'clients' => $clients,
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
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'document' => 'required|string|max:191|unique:clients,document',
            'email' => 'required|string|max:191',
            'phone' => 'required|string|min:8',
            'direction' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            //'category_id' => 'required|exists:categories,id',
        ]);
        //$imgRoute = $request->hasFile('image') ? $request->image->store('clients', 'public') : '';
        Client::create($validated);
        return redirect('clientes')->with('success', 'El cliente ha sido agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'document' => [
                'required',
                'string',
                'max:191',
                Rule::unique('clients')->ignore($request->id),
            ],
            'email' => 'required|string|max:191',
            'phone' => 'required|string|min:8',
            'direction' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before_or_equal:today',
        ]);
        
        try {
            $client = Client::findOrFail($request->id);
            $client->update($validated);
            return redirect()->route('clientes') // Usar nombre de ruta en lugar de URL directa
               ->with('success', 'Cliente actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect('clientes')->with('error', 'No se pudo actualizar el cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            return redirect()
               ->route('clientes')
               ->with('success', 'cliente eliminado correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()
               ->route('clientes')
               ->with('error', 'El cliente no existe o ya fue eliminado');
        }
    }


    public function documentValidation(Request $request)
    {
        $request->validate([
            'document' => 'required|string',
            'client_id' => 'nullable|exists:clients,id' // Para edición
        ]);
    
        $query = Client::where('document', $request->document);
    
        // Si estamos editando (tiene client_id), excluimos ese cliente
        if ($request->has('client_id')) {
            $query->where('id', '!=', $request->client_id);
        }
    
        $exists = $query->exists();
        
        return response()->json([
            'isValid' => !$exists,
            'message' => $exists ? 'El documento ya está registrado' : 'Documento válido'
        ]);
    }
}
