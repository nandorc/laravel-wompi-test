<?php

namespace App\Http\Controllers\Wompi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebCheckoutController extends Controller
{
    public function checkResult(Request $request)
    {
        $id = $request->query('id');
        $env = $request->query('env');
        $endpoint = $env == 'test' ? config('services.wompi.sandbox.endpoint') : config('services.wompi.prod.endpoint');
        $result = json_encode(json_decode(@file_get_contents("$endpoint/transactions/$id"), true), JSON_PRETTY_PRINT);
        return view('pages.widget-webcheckout.response', ['result' => $result]);
    }
    public function sendData(Request $request, $variant)
    {
        $paymentData = [
            // Valores obligatorios
            'reference' => $this->generatePaymentReference(),
            'publicKey' => config('services.wompi.testMode') ? config('services.wompi.sandbox.pubic') : config('services.wompi.prod.public'),
            'currency' => 'COP', // Solo esta disponible el pago en COP
            'amountInCents' => '7890000', // Debe ser el valor en centavos (Ej. 100.000 = 10000000)
            // Valores opcionales
            'redirectUrl' => route('widget-webcheckout.variant.response', ['variant' => $variant]), // ruta para el redireccionamiento
            'shippingAddress' => [
                'addressLine1' => 'Carrera 123 # 4-5', // Requerido
                'addressLine2' => 'apto 123',
                'country' => 'CO', // Requerido en código ISO 3166-1 Alpha-2 (2 letras mayúsculas)
                'city' => 'Bogota', // Requerido
                'phoneNumber' => '3019988888', // Requerido
                'region' => 'Cundinamarca', // Requerido
                'name' => 'Pedro Perez', // Es quien recibiría el paquete
            ],
            'collectShipping' => true, // Activar formulario de datos de envío
            'customerData' => [ // Datos del cliente
                'email' => 'lola@perez.com',
                'fullName' => 'Lola Perez',
                'phoneNumber' => '3019777777', // obligatorio si se define phoneNumberPrefix
                'phoneNumberPrefix' => '+57', // obligatorio si se define phoneNumber
                'legalId' => '123456789', // obligatorio si se define legalIdType
                'legalIdType' => 'CC', // obligatorio si se define legalId, valores posibles: CC, CE, NIT, PP, TI, DNI, RG, OTHER
            ],
            'collectCustomerLegalId' => true, // Activar campos de información de identidad
            'taxInCents' => [ // Detalle de impuestos
                'vat' => '1290000', // IVA (Impuesto de valor agregado)
                'consumption' => '590000', // Impuesto de consumo
            ]
        ];
        return $variant == 'widget' ? view('pages.widget-webcheckout.widget', $paymentData) : view('pages.widget-webcheckout.webcheckout', $paymentData);
    }
    private function generatePaymentReference()
    {
        $availablechars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($availablechars), 0, 10);
    }
}
