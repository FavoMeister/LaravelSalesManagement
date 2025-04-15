<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Products;
use App\Models\Sale;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 'Administrator') {
            return redirect('index');
        }
        $sales = Sale::orderBy('id', 'desc')->get();
        $products = Products::where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        $clients = Client::where('status', 1)->get();
        return view('modules.sales.sales')->with([
            'sales' => $sales,
            'branches' => $branches,
            'clients' => $clients,
            'products' => $products,
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
            //'code' => 'required|string|max:50|unique:sales,code',
            'payment_method' => 'nullable|string|max:50',
            'sale_date' => 'date|before_or_equal:today',
            'branch_id' => 'required|exists:branches,id',
            'client_id' => 'required|exists:clients,id',
            'seller_id' => 'required|exists:users,id',
        ]);
        $lastSaleCount = Sale::count(); // Get the total sales
        $code = ($lastSaleCount + 1) * 1000 + 1;
        Sale::create([
            ...$validated,
            'code' => str_pad($code, 6, '0', STR_PAD_LEFT),
            'status' => 'Creada',
            'sale_date' => now(),
        ]);
        return redirect()->route('ventas')
               ->with('success', 'La venta ha sido creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            if ($sale->status == "Finalizada") {
                return redirect()
                    ->route('ventas')
                    ->with('error', 'No se puede eliminar una venta finalizada');
            }
            $sale->products()->detach();
            $sale->delete();
            return redirect()
               ->route('ventas')
               ->with('success', 'Venta eliminada correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()
               ->route('ventas')
               ->with('error', 'La venta no existe o ya fue eliminada');
        }
    }


    public function adminSale($sale_id)
    {
        $sale = Sale::with('products')->findOrFail($sale_id);
        $products = Products::with('sales')->where('status', 1)->get();
        $addedProductIds = $sale->products->pluck('id')->toArray();
        return view('modules.sales.sale')->with([
            'sale' => $sale,
            'products' => $products,
            'addedProductIds' => $addedProductIds
        ]);
    }

    public function addProductToSale(Request $request)
    {
        $product = Products::findOrFail($request->productId);
        $product->sales()->attach(
            $request->saleId, [
                'quantity' => 1,
                'price' => $product->selling_price,
                'discount' => 0
                ]
        );

        $sale = Sale::findOrFail($request->saleId);
        $sale->update(['status' => 'En Proceso']);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function loadProductSale($sale_id)
    {
        $sale = Sale::with('products')->findOrFail($sale_id);

        return response()->json([
            'success' => true,
            'sale' => $sale
        ]);
    }


    public function deleteProductSale(Request $request)
    {
        $sale = Sale::findOrFail($request->saleId);
        $sale->products()->detach($request->productId);

        return response()->json([
            'success' => true,
            'sale' => $sale->fresh('products')
        ]);
    }


    public function endSale(Request $request)
    {
        $validated = $request->validate([
            'saleId' => 'required|exists:sales,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'payments' => 'required|array',
            'payments.0.tax' => 'required|numeric',
            'payments.0.net_tax' => 'required|numeric',
            'payments.0.total' => 'required|numeric',
            'payments.0.payment_method' => 'required|string',
        ]);
        foreach ($validated['products'] as $product) {
            $productFound = Products::findOrFail($product['id']);
            
            // Verify anough stock
            if ($productFound->stock < $product['quantity']) {
                throw new \Exception("Stock insuficiente para el producto: {$productFound->name}");
            }

            // Record in the pivot table
            $productFound->sales()->updateExistingPivot($validated['saleId'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'discount' => 0
            ]);

            // Update stock y sales
            $productFound->decrement('stock', $product['quantity']);
            $productFound->increment('sale');
        }

        // Update sale
        $sale = Sale::findOrFail($validated['saleId']);
        $sale->update([
            'tax' => $validated['payments'][0]['tax'],
            'net_tax' => $validated['payments'][0]['net_tax'],
            'total' => $validated['payments'][0]['total'],
            'payment_method' => $validated['payments'][0]['payment_method'],
            'status' => 'Finalizada'
            //'completed_at' => now() // Marcar como finalizada
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Venta finalizada correctamente',
            'sale_id' => $sale->id
        ]);

    }
}
