<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;

class TransactionController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayService $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    // make a function index
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            // Admin can see all transactions
            $transactions = Transaction::with(['customer', 'branchStore', 'voucher', 'user', 'service'])->get();
        } else {
            // User can only see their own transactions
            $transactions = Transaction::where('user_id', $user->id)
                                     ->with(['customer', 'branchStore', 'voucher', 'user', 'service'])
                                     ->get();
        }

        return response()->json([
            'message' => 'List of Transactions',
            'data' => $transactions
        ]);
    }

    // make a function show
    public function show($id)
    {
        $transaction = Transaction::with(['customer', 'branchStore', 'voucher', 'service'])->find($id);
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Transaction details',
            'data' => $transaction
        ]);
    }

    // make a function store
    public function store(Request $request)
    {
        try {
            $user = $request->user();
            
            // Different validation rules based on user role
            $validationRules = [
                'branch_store_id' => 'required|exists:branch_stores,id',
                'voucher_id' => 'nullable|exists:vouchers,id',
                'service_id' => 'nullable|exists:services,id',
                'weight' => 'nullable|numeric|min:0',   
                'transaction_date' => 'required|date',
                'base_amount' => 'required|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|in:CASH,TRANSFER',
                'notes' => 'nullable|string|max:255'
            ];

            // For admin, customer_id is required from request
            // For user, we'll get customer_id from user's customer relationship
            if ($user->isAdmin()) {
                $validationRules['customer_id'] = 'required|exists:customers,id';
            }

            $request->validate($validationRules);

            // Handle customer_id based on user role
            if ($user->isUser()) {
                // For regular users, get customer_id from user's customer relationship
                $customer = $user->customer; // Assuming User model has customer relationship
                
                if (!$customer) {
                    return response()->json([
                        'message' => 'Customer profile not found. Please contact administrator to create your customer profile.',
                        'error' => 'No customer profile linked to your account'
                    ], 400);
                }
                
                $customerId = $customer->id;
            } else {
                // For admin, use provided customer_id
                $customerId = $request->customer_id;
            }

            // Calculate discount if voucher is provided
            $discountAmount = 0;

            if ($request->voucher_id) {
                $voucher = \App\Models\Voucher::find($request->voucher_id);
                if ($voucher && isset($voucher->status) && $voucher->status === 'active' && now()->between($voucher->valid_from, $voucher->valid_until)) {
                    $baseAmount = $request->base_amount;
                    if (isset($voucher->discount_type) && $voucher->discount_type === 'percentage') {
                        $discountAmount = $baseAmount * ($voucher->discount_percentage / 100);
                    } else {
                        $discountAmount = $voucher->discount_percentage ?? 0;
                    }
                    // Ensure discount doesn't exceed base amount
                    $discountAmount = min($discountAmount, $baseAmount);
                }
            }

            // Use provided discount amount or calculated one
            $finalDiscountAmount = $request->discount_amount ?? $discountAmount;
            $finalTotalAmount = $request->base_amount - $finalDiscountAmount;

            $transactionData = $request->all();
            $transactionData['customer_id'] = $customerId; // Set customer_id based on user role
            $transactionData['discount_amount'] = $finalDiscountAmount;
            $transactionData['total_amount'] = $finalTotalAmount;
            $transactionData['status_payment'] = 'unpaid';
            $transactionData['status_laundry'] = 'pending';

            // add weight and service_id if provided
            if ($request->has('weight')) {
                $transactionData['weight'] = $request->weight;
            }

            if ($request->has('service_id')) {
                $transactionData['service_id'] = $request->service_id;
            }

            $transactionData['user_id'] = $user->id; // Add user_id

            // Generate payment reference ID
            $referenceId = 'TXN-' . time() . '-' . $customerId;
            $transactionData['payment_reference_id'] = $referenceId;

            $transaction = Transaction::create($transactionData);

            // Handle payment method
            if ($request->payment_method === 'TRANSFER') {
                try {
                    // Create payment via iPaymu
                    $paymentData = [
                        'product_name' => 'Laundry Service - Transaction #' . $transaction->id,
                        'total_amount' => $finalTotalAmount,
                        'reference_id' => $referenceId
                    ];

                    $paymentResult = $this->paymentGateway->createPayment($paymentData);
                    
                    // Update transaction with payment gateway info
                    $transaction->update([
                        'payment_session_id' => $paymentResult['session_id'],
                        'urlPaymentGateway' => $paymentResult['payment_url']
                    ]);

                } catch (\Exception $e) {
                    // If payment gateway fails, still save transaction but mark as failed
                    $transaction->update([
                        'urlPaymentGateway' => null,
                        'notes' => ($transaction->notes ? $transaction->notes . ' | ' : '') . 'Payment gateway error: ' . $e->getMessage()
                    ]);
                }
            } else {
                // For CASH payment, mark as paid immediately
                $transaction->update([
                    'status_payment' => 'paid',
                    'urlPaymentGateway' => null
                ]);
            }

           

            return response()->json([
                'message' => 'Transaction created successfully',
                'data' => $transaction->load(['customer', 'branchStore', 'voucher', 'service'])
            ], 201);

        } catch (\Throwable $th) {


             Log::info($th->getMessage());

            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $th->getMessage()
            ], 500);
            
        }
    }

     
 

    // make a function destroy
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);    
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);
    }

    // Handle payment callback from iPaymu
    public function paymentCallback(Request $request)
    {
        try {
            $referenceId = $request->input('reference_id');
            $status = $request->input('status');
            
            if (!$referenceId) {
                return response()->json(['message' => 'Reference ID required'], 400);
            }

            $transaction = Transaction::where('payment_reference_id', $referenceId)->first();
            
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update payment status based on callback
            if ($status === 'berhasil' || $status === 'success') {
                $transaction->update(['status_payment' => 'paid']);
            } elseif ($status === 'expired' || $status === 'failed') {
                $transaction->update(['status_payment' => 'expired']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment callback failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Check payment status manually
    public function checkPaymentStatus($id)
    {
        try {
            $transaction = Transaction::find($id);
            
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if (!$transaction->payment_session_id) {
                return response()->json(['message' => 'No payment session found'], 400);
            }

            $paymentStatus = $this->paymentGateway->checkPaymentStatus($transaction->payment_session_id);
            
            // Update transaction based on payment status
            if (isset($paymentStatus['Status']) && $paymentStatus['Status'] === 'berhasil') {
                $transaction->update(['status_payment' => 'paid']);
            }

            return response()->json([
                'message' => 'Payment status checked',
                'data' => [
                    'transaction' => $transaction->load(['customer', 'branchStore', 'voucher']),
                    'payment_status' => $paymentStatus
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment status check failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // make a function to handle payment callback
    public function handlePaymentCallback(Request $request)
    { 
        $referenceId = $request->input('reference_id');
        $status = $request->input('status');

        // Find the transaction by reference ID
        $transaction = Transaction::where('payment_reference_id', $referenceId)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);   
        }

        // Update the transaction status based on the payment status
        if ($status === 'berhasil') {
            $transaction->update(['status_payment' => 'paid']);
        } elseif ($status === 'expired' || $status === 'failed') {
            $transaction->update(['status_payment' => 'expired']);  
        }

    }

    // Update laundry status
    public function updateLaundryStatus(Request $request, $id)
    {
        try {
            $transaction = Transaction::find($id);
            
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $request->validate([
                'status_laundry' => 'required|in:pending,processing,completed,cancelled'
            ]);

            // Check valid status transitions
            $currentStatus = $transaction->status_laundry;
            $newStatus = $request->status_laundry;

            $validTransitions = [
                'pending' => ['processing', 'cancelled'],
                'processing' => ['completed', 'cancelled'],
                'completed' => [], // Cannot change from completed
                'cancelled' => [] // Cannot change from cancelled
            ];

            if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
                return response()->json([
                    'message' => "Invalid status transition from {$currentStatus} to {$newStatus}"
                ], 422);
            }

            $transaction->update(['status_laundry' => $newStatus]);

            return response()->json([
                'message' => 'Laundry status updated successfully',
                'data' => $transaction->load(['customer', 'branchStore', 'voucher'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update laundry status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadInvoice($id)
    {
        try {

            $transaction = Transaction::with(['customer', 'branchStore', 'voucher'])->find($id);
           
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Generate invoice PDF
            $pdf = PDF::loadView('invoices.transaction', [
                'transaction' => $transaction,
                'customer' => $transaction->customer,
                'branchStore' => $transaction->branchStore,
                'voucher' => $transaction->voucher,
                'date' => now()->format('Y-m-d H:i:s')
            ]);


            // Set PDF metadata
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true
            ]);

            // Download the PDF
            return $pdf->download('invoice_transaction_' . $transaction->id . '.pdf');
            

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to download invoice',
                'error' => $e->getMessage()
            ], 500);

        } 
    }

    

}
