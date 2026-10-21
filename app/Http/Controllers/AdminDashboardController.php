<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the general administration dashboard.
     */
    public function index()
    {
        $lowStockThreshold = Product::LOW_STOCK_THRESHOLD;

        // 1. Total de productos, activos e inactivos
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = $totalProducts - $activeProducts;

        // 2. Stock bajo (0 < stock <= threshold) y agotados (stock = 0)
        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', $lowStockThreshold)
            ->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        // 3. Valor total del inventario (activos: SUM(COALESCE(price, 0) * stock))
        $totalInventoryValue = (float) (Product::where('is_active', true)
            ->selectRaw('SUM(COALESCE(price, 0) * stock) as total_value')
            ->value('total_value') ?? 0);

        // 4. Total de usuarios, administradores y regulares
        $totalUsers = User::count();
        $adminUsers = User::whereHas('role', function ($query) {
            $query->where('description', 'Admin');
        })->count();
        $regularUsers = $totalUsers - $adminUsers;

        // 5. Listas cortas: 5 con menor stock y 5 últimos creados
        $lowestStockProducts = Product::orderBy('stock', 'asc')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();

        $latestProducts = Product::orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalInventoryValue',
            'totalUsers',
            'adminUsers',
            'regularUsers',
            'lowestStockProducts',
            'latestProducts',
            'lowStockThreshold'
        ));
    }
}
