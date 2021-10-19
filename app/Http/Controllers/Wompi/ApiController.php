<?php

namespace App\Http\Controllers\Wompi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $endpoint;
    private $publicKey;
    private $privateKey;



    public function __construct()
    {
        $this->endpoint = config('services.wompi.testMode') ? config('services.wompi.sandbox.endpoint') : config('services.wompi.prod.endpoint');
        $this->publicKey = config('services.wompi.testMode') ? config('services.wompi.sandbox.pubic') : config('services.wompi.prod.public');
        $this->privateKey = config('services.wompi.testMode') ? config('services.wompi.sandbox.private') : config('services.wompi.prod.private');
    }

    public function acceptanceToken(Request $request)
    {
        $result = $this->getAcceptanceToken();
        return view('pages.payment-api.response', ['response' => $result['response']]);
    }

    public function payUsingCard(Request $request)
    {
        // Tokenizar
        $tokenizationResult = $this->getTokenizedCard();
        $error = !$tokenizationResult['continue'];
        $response = $tokenizationResult['response'];
        // Solicitar aceptación de términos
        if (!$error) {
            $acceptanceResult = $this->getAcceptanceToken();
            $error = !$acceptanceResult['continue'];
            $response .= $acceptanceResult['response'];
        }
        // Realizar transacción
        if (!$error) {
            $paymentMethod = [
                'type' => 'CARD',
                'installments' => 2, // Numero de cuotas
                'token' => $tokenizationResult['token']
            ];
            $transactionResult = $this->sendTransaction($acceptanceResult['token'], $paymentMethod);
            $error = !$transactionResult['continue'];
            $response .= $transactionResult['response'];
        }
        return view('pages.payment-api.response', ['response' => $response]);
    }

    private function sendTransaction(string $acceptanceToken, array $paymentMethod)
    {
        $headers = ["Authorization:Bearer $this->privateKey"];
        $payload = $this->buildTransaction($acceptanceToken, $paymentMethod);
        $curlResult = $this->makeCurlPostRequest("$this->endpoint/transactions", $payload, $headers);
        $result = ['continue' => false, 'response' => $curlResult['formattedResponse']];
        return $result;
    }

    private function buildTransaction(string $acceptanceToken, array $paymentMethod)
    {
        $transaction = [
            "acceptance_token" => $acceptanceToken,
            "amount_in_cents" => 3000000,
            "currency" => "COP",
            "customer_email" => "example@wompi.co",
            "payment_method" => $paymentMethod,
            "reference" => $this->generatePaymentReference(),
            "customer_data" => [
                "phone_number" => "573307654321",
                "full_name" => "Juan Alfonso Pérez Rodríguez"
            ],
            "shipping_address" => [
                "address_line_1" => "Calle 34 # 56 - 78",
                "address_line_2" => "Apartamento 502, Torre I",
                "country" => "CO",
                "region" => "Cundinamarca",
                "city" => "Bogotá",
                "name" => "Pepe Perez",
                "phone_number" => "573109999999",
                "postal_code" => "111111"
            ]
        ];
        return $transaction;
    }

    private function getTokenizedCard()
    {
        $headers = ["Authorization:Bearer $this->publicKey"];
        $payload = [
            'number' => '4242424242424242',
            'cvc' => '123',
            'exp_month' => '08', // string de dos digitos
            'exp_year' => '28',
            'card_holder' => 'José Pérez'
        ];
        $curlResult = $this->makeCurlPostRequest("$this->endpoint/tokens/cards", $payload, $headers);
        $result = ['continue' => false, 'response' => $curlResult['formattedResponse']];
        $responseArray = $curlResult['responseArray'];
        if (isset($responseArray['data']['id'])) {
            $result['token'] = $responseArray['data']['id'];
            $result['continue'] = true;
        }
        return $result;
    }

    private function getAcceptanceToken()
    {
        $curlResult = $this->makeCurlGetRequest("$this->endpoint/merchants/$this->publicKey");
        $result = ['continue' => false, 'response' => $curlResult['formattedResponse']];
        $responseArray = $curlResult['responseArray'];
        if (isset($responseArray['data']['presigned_acceptance']['acceptance_token'])) {
            $result['token'] = $responseArray['data']['presigned_acceptance']['acceptance_token'];
            $result['continue'] = true;
        }
        return $result;
    }

    private function makeCurlGetRequest(string $endpoint, array $headers = [])
    {
        return $this->makeCurlRequest($endpoint, 'GET', [], $headers);
    }

    private function makeCurlPostRequest(string $endpoint, array $data, array $headers = [])
    {
        return $this->makeCurlRequest($endpoint, 'POST', $data, $headers);
    }

    private function makeCurlRequest(string $endpoint, string $method, array $data = [], array $headers = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            $headers[] = 'Content-Type:application/json';
        }
        if (sizeof($headers) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        $data = curl_exec($curl);
        curl_close($curl);
        $dataArray = json_decode($data, true);
        return ['responseArray' => $dataArray, 'formattedResponse' => $this->formatResponse($endpoint, $dataArray)];
    }

    private function formatResponse(string $endpoint, array $responseData)
    {
        $formattedTitle = "Response for: <i>$endpoint</i>";
        $formattedData = json_encode($responseData, JSON_PRETTY_PRINT);
        $response = "<div style=\"margin: 1rem; padding: 1rem; border: 1px solid black;\">";
        $response .= "<h2 style=\"margin-top: 0; margin-bottom: 1rem;\">$formattedTitle</h2>";
        $response .= "<pre style=\"overflow: auto; margin: 0;\">$formattedData</pre>";
        $response .= "</div>";
        return $response;
    }

    private function generatePaymentReference()
    {
        $availablechars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($availablechars), 0, 10);
    }
}
