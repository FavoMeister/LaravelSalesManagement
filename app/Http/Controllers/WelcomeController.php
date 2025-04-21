<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Products;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
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
        if (Auth::user()->role == 'Administrator') {
            $sales = Sale::where('status', 'Finalizada')->sum('total');
        } elseif (Auth::user()->role == 'Manager') {
            $sales = Sale::where('status', 'Finalizada')->where('branch_id', Auth::user()->branch_id)->sum('total');
        } else {
            $sales = Sale::where('status', 'Finalizada')->where('seller_id', Auth::user()->id)->sum('total');
        }
        
        $products = Products::where('status', 1)->count();
        $branches = Branch::where('status', 1)->count();
        $categories = Category::where('status', 1)->count();
        $clients = Client::where('status', 1)->count();


        $salesQuery = Sale::query()->orderBy('sale_date', 'asc');

        if (Auth::user()->role != "Administrator") {
            $salesQuery->where('branch_id', Auth::user()->branch_id);
        }

        /* --------------------- First Graphic - Monthly Sales Data (processed in database) --------------------- */
        $monthlySales = $salesQuery->select(
                'sales.id as saleId',
                'sales.seller_id',
                'sales.net_tax',
                DB::raw("DATE_FORMAT(sale_date, '%Y-%m-%d') as month"),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('ANY_VALUE(sale_date) as sale_date') // Para MySQL 8.0+
            )
            ->groupBy('month', 'saleId')
            ->orderBy('sale_date', 'asc')
            ->get();

        $dontRepeatDates = $monthlySales->pluck('month')->toArray();
        $paymentMonthSum = $monthlySales->pluck('total_sales', 'month')->toArray();

        /* --------------------- Second Graphic --------------------- */
        $saleIds = $salesQuery->get()->pluck('saleId');
        $totalSales = $saleIds->count();

        // Only query product sales if there are sales
        $bestSellingProducts = collect();
        $totalProductSales = 0;
        if ($totalSales > 0) {
            $totalProductSales = DB::table('product_sales')
                ->whereIn('sale_id', $saleIds->toArray())
                ->count();

            $bestSellingProducts = Products::select(
                'products.id as product_id',
                'products.name',
                'products.description',
                'products.image',
                DB::raw('COUNT(product_sales.id) as sales_count'),
                DB::raw('ROUND((COUNT(product_sales.id) / '.$totalProductSales.') * 100, 2) as percentage')
            )
            ->join('product_sales', 'products.id', '=', 'product_sales.product_id')
            ->whereIn('product_sales.sale_id', $saleIds->toArray())
            ->groupBy('products.id', 'products.name', 'products.description', 'products.image')
            ->orderByDesc('sales_count')
            ->take(10)
            ->get();
        }
        
        $colorVariables = [
            '#f56954',
            '#00a65a',
            '#f39c12',
            '#00c0ef'
          ];

        $latestProducts = Products::where('status', 1)->orderBy('created_at', 'desc')->take(10)->get();
        $mySales = Sale::where('seller_id', Auth::user()->id)->orderBy('id', 'asc')->get();

        return view('modules.index.index')->with([
            'sales' => $sales,
            'branches' => $branches,
            'categories' => $categories,
            'clients' => $clients,
            'products' => $products,
            'dontRepeatDates' => $dontRepeatDates,
            'paymentMonthSum' => $paymentMonthSum,
            'colorVariables' => $colorVariables,
            'bestSellingProducts' => $bestSellingProducts,
            'latestProducts' => $latestProducts,
            'mySales' => $mySales,
        ]);
        /* Change all return redirect('index'); por return redirect('inicio');*/
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
