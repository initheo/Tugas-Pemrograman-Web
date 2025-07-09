<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\BranchStore;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get total customers
            $totalCustomers = Customer::count();
            
            // Get total branches
            $totalBranches = BranchStore::count();
            
            // Get active vouchers (jika field status ada)
            $activeVouchers = Voucher::where(function($query) {
                $query->where('status', 'active')
                      ->orWhereNull('status'); // Include vouchers without status field
            })
            ->where('valid_until', '>=', now())
            ->count();
            
            // Get total transactions
            $totalTransactions = Transaction::count();
            
            // Get total revenue
            $totalRevenue = Transaction::sum('total_amount') ?? 0;
            
            // Get 5 best customers
            $bestCustomers = Customer::select('customers.*')
                ->selectRaw('COALESCE(SUM(transactions.total_amount), 0) as total_amount')
                ->selectRaw('COUNT(transactions.id) as total_transactions')
                ->leftJoin('transactions', 'customers.id', '=', 'transactions.customer_id')
                ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.created_at', 'customers.updated_at')
                ->orderBy('total_amount', 'desc')
                ->take(5)
                ->get()
                ->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'total_amount' => (int) $customer->total_amount,
                        'total_transactions' => (int) $customer->total_transactions
                    ];
                });
            
            // Get 5 best branches
            $bestBranches = BranchStore::select('branch_stores.*')
                ->selectRaw('COALESCE(SUM(transactions.total_amount), 0) as total_revenue')
                ->selectRaw('COUNT(transactions.id) as total_transactions')
                ->leftJoin('transactions', 'branch_stores.id', '=', 'transactions.branch_store_id')
                ->groupBy('branch_stores.id', 'branch_stores.name', 'branch_stores.address', 'branch_stores.created_at', 'branch_stores.updated_at')
                ->orderBy('total_revenue', 'desc')
                ->take(5)
                ->get()
                ->map(function ($branch) {
                    return [
                        'id' => $branch->id,
                        'name' => $branch->name,
                        'address' => $branch->address,
                        'total_revenue' => (int) $branch->total_revenue,
                        'total_transactions' => (int) $branch->total_transactions
                    ];
                });
            
            // Calculate growth percentages (comparing with previous period)
            $previousWeekCustomers = Customer::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count();
            
            $currentWeekCustomers = Customer::where('created_at', '>=', now()->subDays(7))
                ->count();
            
            $customerGrowth = $previousWeekCustomers > 0 
                ? round((($currentWeekCustomers - $previousWeekCustomers) / $previousWeekCustomers) * 100, 1)
                : ($currentWeekCustomers > 0 ? 100 : 0);
            
            // Similar calculation for branches
            $previousWeekBranches = BranchStore::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count();
            
            $currentWeekBranches = BranchStore::where('created_at', '>=', now()->subDays(7))
                ->count();
            
            $branchGrowth = $previousWeekBranches > 0 
                ? round((($currentWeekBranches - $previousWeekBranches) / $previousWeekBranches) * 100, 1)
                : ($currentWeekBranches > 0 ? 100 : 0);
            
            // Voucher growth
            $previousWeekVouchers = Voucher::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count();
            
            $currentWeekVouchers = Voucher::where('created_at', '>=', now()->subDays(7))
                ->count();
            
            $voucherGrowth = $previousWeekVouchers > 0 
                ? round((($currentWeekVouchers - $previousWeekVouchers) / $previousWeekVouchers) * 100, 1)
                : ($currentWeekVouchers > 0 ? 100 : 0);
            
            return response()->json([
                'message' => 'Dashboard data retrieved successfully',
                'data' => [
                    'stats' => [
                        'total_customers' => $totalCustomers,
                        'total_branches' => $totalBranches,
                        'active_vouchers' => $activeVouchers,
                        'total_transactions' => $totalTransactions,
                        'total_revenue' => $totalRevenue
                    ],
                    'growth' => [
                        'customers' => $customerGrowth,
                        'branches' => $branchGrowth,
                        'vouchers' => $voucherGrowth
                    ],
                    'best_customers' => $bestCustomers,
                    'best_branches' => $bestBranches
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
