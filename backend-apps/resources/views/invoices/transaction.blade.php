<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .invoice-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .invoice-body {
            padding: 30px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 30px;
        }

        .info-section {
            flex: 1;
        }

        .info-title {
            font-size: 14px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        .info-content {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .transaction-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-unpaid {
            background: #fff3cd;
            color: #856404;
        }

        .status-expired {
            background: #f8d7da;
            color: #721c24;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .status-pending {
            background: #e2e3e5;
            color: #383d41;
        }

        .amount-section {
            border-top: 2px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }

        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .amount-row.total {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
            border-top: 2px solid #667eea;
            padding-top: 15px;
            margin-top: 15px;
        }

        .voucher-info {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }

        .voucher-title {
            font-weight: bold;
            color: #2d5a2d;
            margin-bottom: 5px;
        }

        .voucher-details {
            color: #4a7c4a;
            font-size: 14px;
        }

        .invoice-footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            border-top: 1px solid #eee;
        }

        .footer-note {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 12px;
            color: #999;
        }

        @media print {
            body {
                background: white;
            }
            
            .invoice-container {
                box-shadow: none;
                margin: 0;
            }
            
            .invoice-header {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        @media (max-width: 600px) {
            .invoice-info {
                flex-direction: column;
                gap: 20px;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .amount-row {
                font-size: 14px;
            }
            
            .amount-row.total {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-subtitle">Transaction #{{ $transaction->id }}</div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            <!-- Invoice Information -->
            <div class="invoice-info">
                <div class="info-section">
                    <div class="info-title">Bill To</div>
                    <div class="info-content"><strong>{{ $transaction->customer->name }}</strong></div>
                    <div class="info-content">{{ $transaction->customer->email }}</div>
                    <div class="info-content">{{ $transaction->customer->phone }}</div>
                    @if($transaction->customer->address)
                        <div class="info-content">{{ $transaction->customer->address }}</div>
                    @endif
                </div>
                
                <div class="info-section">
                    <div class="info-title">Invoice Details</div>
                    <div class="info-content"><strong>Invoice #:</strong> {{ $transaction->id }}</div>
                    <div class="info-content"><strong>Date:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</div>
                    <div class="info-content"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->addDays(7)->format('M d, Y') }}</div>
                    <div class="info-content"><strong>Branch:</strong> {{ $transaction->branchStore->name }}</div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="transaction-details">
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value">{{ ucfirst($transaction->payment_method) }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Payment Status:</span>
                        <span class="detail-value">
                            <span class="status-badge status-{{ $transaction->status_payment }}">
                                {{ ucfirst($transaction->status_payment) }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Laundry Status:</span>
                        <span class="detail-value">
                            <span class="status-badge status-{{ $transaction->status_laundry }}">
                                {{ ucfirst($transaction->status_laundry) }}
                            </span>
                        </span>
                    </div>
                    
                    @if($transaction->notes)
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value">{{ $transaction->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Voucher Information (if applied) -->
            @if($transaction->voucher)
            <div class="voucher-info">
                <div class="voucher-title">🎟️ Voucher Applied</div>
                <div class="voucher-details">
                    <strong>{{ $transaction->voucher->name }}</strong><br>
                    Discount: {{ $transaction->voucher->discount_percentage }}%
                    @if($transaction->voucher->minimum_purchase)
                        | Min. Purchase: Rp {{ number_format($transaction->voucher->minimum_purchase, 0, ',', '.') }}
                    @endif
                </div>
            </div>
            @endif

            <!-- Amount Breakdown -->
            <div class="amount-section">
                <div class="amount-row">
                    <span>Base Amount:</span>
                    <span>Rp {{ number_format($transaction->base_amount, 0, ',', '.') }}</span>
                </div>
                
                @if($transaction->voucher && $transaction->discount_amount > 0)
                <div class="amount-row">
                    <span>Discount ({{ $transaction->voucher->discount_percentage }}%):</span>
                    <span>- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="amount-row total">
                    <span>Total Amount:</span>
                    <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-note">
                <strong>Thank you for your business!</strong>
            </div>
            <div class="footer-note">
                Please keep this invoice for your records.
            </div>
            <div class="company-info">
                Generated on {{ now()->format('M d, Y H:i:s') }} | 
                {{ config('app.name', 'Laundry Management System') }}
            </div>
        </div>
    </div>
</body>
</html>