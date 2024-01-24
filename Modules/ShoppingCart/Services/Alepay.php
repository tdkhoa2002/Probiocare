<?php
namespace Modules\ShoppingCart\Services;

use Illuminate\Support\Facades\Http; 

class Alepay {
    protected $tokenKey;
    protected $checksumKey;
    protected $encryptKey;
    protected $baseUrl;

    protected $api = [
        'requestPayment' => '/request-payment',
        'getTransactionInfo' => '/get-transaction-info'
    ];

    public function __construct(){
        $this->tokenKey = config('asgard.shoppingcart.config.alepay.token_key');
        $this->checksumKey = config('asgard.shoppingcart.config.alepay.checksum_key');
        $this->encryptKey = config('asgard.shoppingcart.config.alepay.encrypt_key');
        $this->baseUrl = config('asgard.shoppingcart.config.alepay.base_url');
    }

    public function requestPayment($data)
    {
        return $this->sendRequestToAlepay($data, $this->api['requestPayment']);
    }

    private function sendRequestToAlepay($data, $endpoint)
    {
        try 
        {
            // Thêm các thông tin cần thiết vào $data
            $data['tokenKey'] = $this->tokenKey;
            $data['signature'] = $this->generateSignature($data);

            // Gửi request đến Alepay
            $response = Http::post($this->baseUrl . $endpoint, $data);

            // Xử lý response
            $data = $response->json();
            return $data;
        }
        catch (\Exception $e)
        {
            \Log::error($e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getTransactionInfo($transactionCode)
    {
        return $this->sendRequestToAlepay($transactionCode, $this->api['getTransactionInfo']);
    }

    private function generateSignature($data)
    {
        // Sắp xếp các key theo alphabet
        ksort($data);
        // Dữ liệu signature
        $dataString = urldecode(http_build_query($data));
        // Tạo signature theo thuật toán HMAC_SHA256
        $signature = HASH_HMAC('sha256', $dataString, $this->checksumKey);
        // Thêm chữ ký vào trong danh sách data
        $data['signature'] = $signature;
        // Tạo chữ ký
        return $signature;
    }
}
?>