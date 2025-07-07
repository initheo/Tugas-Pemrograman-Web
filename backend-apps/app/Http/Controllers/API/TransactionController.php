<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaymentGatewayService;

class TransactionController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayService $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    // make a function index
    public function index()
    {
        $transactions = Transaction::with(['customer', 'branchStore', 'voucher'])->get();

        return response()->json([
            'message' => 'List of Transactions',
            'data' => $transactions
        ]);
    }

    // make a function show
    public function show($id)
    {
        $transaction = Transaction::with(['customer', 'branchStore', 'voucher'])->find($id);
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

            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'branch_store_id' => 'required|exists:branch_stores,id',
                'voucher_id' => 'nullable|exists:vouchers,id',
                'transaction_date' => 'required|date',
                'base_amount' => 'required|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|in:CASH,TRANSFER',
                'notes' => 'nullable|string|max:255'
            ]);

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
            $transactionData['discount_amount'] = $finalDiscountAmount;
            $transactionData['total_amount'] = $finalTotalAmount;
            $transactionData['status_payment'] = 'unpaid';
            $transactionData['status_laundry'] = 'pending';

            // Generate payment reference ID
            $referenceId = 'TXN-' . time() . '-' . $transactionData['customer_id'];
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
                'data' => $transaction->load(['customer', 'branchStore', 'voucher'])
            ], 201);

        } catch (\Throwable $th) {

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

}
