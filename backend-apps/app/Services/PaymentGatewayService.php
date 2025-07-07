<?php

namespace App\Services;

use Exception;

class PaymentGatewayService
{
    private $va;
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->va = config('payment.ipaymu.va', '1179000899');
        $this->apiKey = config('payment.ipaymu.api_key', 'QbGcoO0Qds9sQFDmY0MWg1Tq.xtuh1');
        $this->baseUrl = config('payment.ipaymu.base_url', 'https://sandbox.ipaymu.com/api/v2');
    }

    /**
     * Create payment via iPaymu
     *
     * @param array $transactionData
     * @return array
     * @throws Exception
     */
    public function createPayment($transactionData)
    {
        $url = $this->baseUrl . '/payment';
        $method = 'POST';

        // Prepare request body
        $body = [
            'product' => [$transactionData['product_name'] ?? 'Laundry Service'],
            'qty' => [1],
            'price' => [(int) $transactionData['total_amount']],
            // 'returnUrl' => config('app.url') . '/payment/success',
            // 'cancelUrl' => config('app.url') . '/payment/cancel',
            'notifyUrl' => config('app.url') . '/api/payment/callback',
            'referenceId' => $transactionData['reference_id']
        ];

        // Generate signature
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);
        $timestamp = date('YmdHis');

        // Prepare headers
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $this->va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        ];

        // Execute cURL request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($err) {
            throw new Exception('Payment gateway error: ' . $err);
        }

        $result = json_decode($response, true);

        if (!$result || $result['Status'] !== 200) {
            throw new Exception('Payment gateway failed: ' . ($result['Message'] ?? 'Unknown error'));
        }

        return [
            'session_id' => $result['Data']['SessionID'],
            'payment_url' => $result['Data']['Url'],
            'reference_id' => $transactionData['reference_id']
        ];
    }

    /**
     * Check payment status
     *
     * @param string $transactionId
     * @return array
     * @throws Exception
     */
    public function checkPaymentStatus($transactionId)
    {
        $url = $this->baseUrl . '/history';
        $method = 'POST';

        $body = [
            'transactionId' => $transactionId
        ];

        // Generate signature
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);
        $timestamp = date('YmdHis');

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $this->va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($err) {
            throw new Exception('Payment status check error: ' . $err);
        }

        $result = json_decode($response, true);

        if (!$result || $result['Status'] !== 200) {
            throw new Exception('Payment status check failed: ' . ($result['Message'] ?? 'Unknown error'));
        }

        return $result['Data'];
    }
}
