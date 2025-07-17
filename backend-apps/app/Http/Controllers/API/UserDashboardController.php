<?php

namespace App\Http\Controllers\API;

use App\Models\Voucher;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Get user dashboard statistics
     */
    public function getDashboardStats(Request $request)
    {
        $user = $request->user();
 
        // Get or create customer associated with this user
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            // Auto-create customer profile with basic info from user
            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => null,
                'address' => null,
                'city' => null,
                'postal_code' => null
            ]);

            Log::info('Created new customer profile', ['customer_id' => $customer->id]);
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
                'amount' => (float) $amount // Ensure numeric type
            ];
        }

        return response()->json([
            'message' => 'User dashboard statistics',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'customer' => $customer,
                'stats' => [
                    'totalTransactions' => $totalTransactions,
                    'totalSpent' => (float) $totalSpent,
                    'totalSavings' => (float) $totalSavings,
                    'monthlySpending' => (float) $monthlySpending
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

        // Get or create customer associated with this user
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            // Auto-create customer profile with basic info from user
            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => null,
                'address' => null,
                'city' => null,
                'postal_code' => null
            ]);
        }

        $transactions = Transaction::where('customer_id', $customer->id)
            ->with(['customer', 'branchStore', 'voucher'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json([
            'message' => 'User transactions',
            'data' => $transactions
        ]);
    }

    /**
     * Get available vouchers for user
     */
    public function getAvailableVouchers(Request $request)
    {
        $vouchers = Voucher::where('valid_until', '>', now())
            ->where('valid_from', '<=', now())
            ->get();

        return response()->json([
            'message' => 'Available vouchers',
            'data' => $vouchers
        ]);
    }

    /**
     * Get available branches for user
     */
    public function getAvailableBranches(Request $request)
    {
        try {
            $branches = \App\Models\BranchStore::all();

            return response()->json([
                'message' => 'Available branches',
                'data' => $branches
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving branches: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user profile including customer data
     */
    public function getUserProfile(Request $request)
    {
        try {
            $user = $request->user();

            // Get or create customer data linked to this user
            $customer = Customer::where('user_id', $user->id)->first();

            if (!$customer) {
                // Auto-create customer profile with basic info from user
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => null,
                    'address' => null,
                    'city' => null,
                    'postal_code' => null
                ]);
            }

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
