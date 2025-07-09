<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Voucher;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    /**
     * Get user dashboard statistics
     */
    public function getDashboardStats(Request $request)
    {
        $user = $request->user();
        
        // Get customer associated with this user
        $customer = Customer::where('user_id', $user->id)->first();
        
        if (!$customer) {
            return response()->json([
                'message' => 'No customer profile found for this user',
                'data' => [
                    'stats' => [
                        'totalTransactions' => 0,
                        'totalSpent' => 0,
                        'totalSavings' => 0,
                        'monthlySpending' => 0
                    ],
                    'recentTransactions' => [],
                    'spendingByMonth' => []
                ]
            ]);
        }
        
        // Get user's transactions via customer relationship
        $userTransactions = Transaction::where('customer_id', $customer->id)
                                    ->with(['customer', 'branchStore', 'voucher'])
                                    ->get();

        // Calculate statistics
        $totalTransactions = $userTransactions->count();
        $totalSpent = $userTransactions->sum('total_amount');
        $totalSavings = $userTransactions->sum('discount_amount');
        
        // Monthly spending
        $monthlySpending = Transaction::where('customer_id', $customer->id)
                                    ->whereMonth('transaction_date', now()->month)
                                    ->whereYear('transaction_date', now()->year)
                                    ->sum('total_amount');

        // Recent transactions
        $recentTransactions = Transaction::where('customer_id', $customer->id)
                                       ->with(['customer', 'branchStore', 'voucher'])
                                       ->orderBy('transaction_date', 'desc')
                                       ->limit(5)
                                       ->get();

        // Spending by month for chart (last 6 months)
        $spendingByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $amount = Transaction::where('customer_id', $customer->id)
                               ->whereMonth('transaction_date', $date->month)
                               ->whereYear('transaction_date', $date->year)
                               ->sum('total_amount');
            
            $spendingByMonth[] = [
                'month' => $date->format('M Y'),
                'amount' => $amount
            ];
        }

        return response()->json([
            'message' => 'User dashboard statistics',
            'data' => [
                'stats' => [
                    'totalTransactions' => $totalTransactions,
                    'totalSpent' => $totalSpent,
                    'totalSavings' => $totalSavings,
                    'monthlySpending' => $monthlySpending
                ],
                'recentTransactions' => $recentTransactions,
                'spendingByMonth' => $spendingByMonth
            ]
        ]);
    }

    /**
     * Get user's transactions
     */
    public function getUserTransactions(Request $request)
    {
        $user = $request->user();
        
        // Get customer associated with this user
        $customer = Customer::where('user_id', $user->id)->first();
        
        if (!$customer) {
            return response()->json([
                'message' => 'No customer profile found for this user',
                'data' => []
            ]);
        }
        
        $transactions = Transaction::where('customer_id', $customer->id)
                                 ->with(['customer', 'branchStore', 'voucher'])
                                 ->orderBy('transaction_date', 'desc')
                                 ->paginate(10);

        return response()->json([
            'message' => 'User transactions',
            'data' => $transactions
        ]);
    }

    /**
     * Get available vouchers for user
     */
    public function getAvailableVouchers()
    {
        $vouchers = Voucher::where('valid_until', '>=', now())
                          ->orderBy('discount_percentage', 'desc')
                          ->get();

        return response()->json([
            'message' => 'Available vouchers',
            'data' => $vouchers
        ]);
    }

    /**
     * Get user profile including customer data
     */
    public function getUserProfile(Request $request)
    {
        try {
            $user = $request->user();
            
            // Get customer data linked to this user
            $customer = Customer::where('user_id', $user->id)->first();
            
            $profileData = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'customer' => $customer
            ];

            return response()->json([
                'message' => 'User profile retrieved successfully',
                'data' => $profileData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving user profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
