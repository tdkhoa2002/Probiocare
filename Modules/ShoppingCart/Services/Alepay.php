<?php

namespace Modules\ShoppingCart\Services;

class Alepay
{
	protected $tokenKey;
	protected $checksumKey;
	protected $encryptKey;
	protected $baseApiUrl;

	protected $api = [
		'requestPayment' => '/request-payment'
	];

	public function __construct()
	{
		$this->baseApiUrl = config('asgard.shoppingcart.config.payment_methods.alepay.base_api_url');
		$this->checksumKey = config('asgard.shoppingcart.config.payment_methods.alepay.checksum_key');
		$this->encryptKey = config('asgard.shoppingcart.config.payment_methods.alepay.encrypt_key');
		$this->tokenKey = config('asgard.shoppingcart.config.payment_methods.alepay.token_key');
	}

	public function requestPayment($data)
	{
		
		return $this->sendRequestToAlepay($data, $this->api['requestPayment']);
	}

	private function sendRequestToAlepay($data, $endpoint)
	{
		try {
			$data['tokenKey'] = $this->tokenKey;
			ksort($data);
			$signature = hash_hmac('sha256', $this->build_query_data($data), $this->checksumKey);
			$data['signature'] = $signature;
			$data_string = json_encode($data);
			$url = $this->baseApiUrl . $endpoint;

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt(
				$ch,
				CURLOPT_HTTPHEADER,
				[
					'Content-Type: application/json'
				]
			);
			$result = curl_exec($ch);
			curl_close($ch);

			return json_decode($result);
		} catch (\Exception $e) {
			\Log::error($e->getMessage());
			return false;
		}
	}

	private function build_query_data($array)
	{
		return urldecode(http_build_query(array_map(function ($value) {
			if ($value === true) {
				return 'true';
			}
			if ($value === false) {
				return 'false';
			}

			return $value;
		}, $array)));
	}
}
