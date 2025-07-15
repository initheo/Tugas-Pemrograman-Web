<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Laundry Selesai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #3498db;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #3498db;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .content {
            padding: 0 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .status-badge {
            background-color: #27ae60;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin: 20px 0;
        }
        .transaction-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .pickup-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .pickup-info h3 {
            margin: 0 0 10px 0;
            color: #3498db;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
            margin-top: 30px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .contact-info h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LaundryEase</h1>
            <p>Layanan Laundry Terpercaya</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo {{ $customer->name }},
            </div>
            
            <p>Kabar baik! Pesanan laundry Anda telah selesai dan siap untuk diambil.</p>
            
            <div class="status-badge">
                ✅ SELESAI
            </div>
            
            <div class="transaction-details">
                <h3 style="margin: 0 0 15px 0; color: #333;">Detail Pesanan:</h3>
                
                <div class="detail-row">
                    <span class="detail-label">ID Transaksi:</span>
                    <span class="detail-value">#{{ $transaction->id }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Tanggal Transaksi:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d F Y') }}</span>
                </div>
                
                @if($service)
                <div class="detail-row">
                    <span class="detail-label">Layanan:</span>
                    <span class="detail-value">{{ $service->name }}</span>
                </div>
                @endif
                
                @if($transaction->weight)
                <div class="detail-row">
                    <span class="detail-label">Berat:</span>
                    <span class="detail-value">{{ $transaction->weight }} kg</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Total Pembayaran:</span>
                    <span class="detail-value"><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status Pembayaran:</span>
                    <span class="detail-value">
                        @if($transaction->status_payment === 'paid')
                            <span style="color: #27ae60; font-weight: bold;">✅ LUNAS</span>
                        @else
                            <span style="color: #e74c3c; font-weight: bold;">❌ BELUM LUNAS</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="pickup-info">
                <h3>📍 Informasi Pengambilan:</h3>
                <p><strong>Lokasi:</strong> {{ $branchStore->name }}</p>
                <p><strong>Alamat:</strong> {{ $branchStore->address }}</p>
                @if($branchStore->phone)
                <p><strong>Telepon:</strong> {{ $branchStore->phone }}</p>
                @endif
                <p><strong>Jam Operasional:</strong> Senin - Minggu, 08:00 - 20:00</p>
            </div>
            
            @if($transaction->status_payment !== 'paid')
            <div style="background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
                <h4 style="margin: 0 0 10px 0; color: #856404;">⚠️ Perhatian:</h4>
                <p style="margin: 0; color: #856404;">Mohon selesaikan pembayaran sebelum mengambil laundry Anda.</p>
            </div>
            @endif
            
            <div class="contact-info">
                <h4>📞 Hubungi Kami:</h4>
                <p>Jika ada pertanyaan atau kendala, jangan ragu untuk menghubungi kami:</p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>WhatsApp: +62 812-3456-7890</li>
                    <li>Email: support@laundrease.com</li>
                    <li>Telepon: (021) 123-4567</li>
                </ul>
            </div>
            
            <p style="margin-top: 30px;">
                Terima kasih telah mempercayakan kebutuhan laundry Anda kepada kami. 
                Kami berkomitmen untuk memberikan layanan terbaik untuk Anda.
            </p>
            
            <p style="font-weight: bold; color: #3498db;">
                Salam hangat,<br>
                Tim LaundryEase
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} LaundryEase. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
