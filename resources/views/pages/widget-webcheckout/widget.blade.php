@extends('templates.layout-breadcrumb')
@section('head__title', 'Widget')
@section('section__content')
  <div>
    <h2>Información para el pago</h2>
    <table>
      <tr>
        <td>Referencia de pago:</td>
        <td>{{ $reference ?? '' }}</td>
      </tr>
    </table>
    <h2>Botón de Pago</h2>
    <form>
      <script src="https://checkout.wompi.co/widget.js"
        data-render="button"
        data-public-key="{{ $publicKey ?? '' }}"
        data-currency="{{ $currency ?? '' }}"
        data-amount-in-cents="{{ $amountInCents ?? '' }}"
        data-reference="{{ $reference ?? '' }}"
        @isset($redirectUrl) data-redirect-url="{{ $redirectUrl }}" @endisset
        @isset($shippingAddress)
            data-shipping-address:address-line-1="{{ $shippingAddress['addressLine1'] ?? '' }}"
            @isset($shippingAddress['addressLine2']) data-shipping-address:address-line-2="{{ $shippingAddress['addressLine2'] }}" @endisset
            data-shipping-address:country="{{ $shippingAddress['country'] ?? '' }}"
            data-shipping-address:city="{{ $shippingAddress['city'] ?? '' }}"
            data-shipping-address:phone-number="{{ $shippingAddress['phoneNumber'] ?? '' }}"
            data-shipping-address:region="{{ $shippingAddress['region'] ?? '' }}"
            @isset($shippingAddress['name']) data-shipping-address:name="{{ $shippingAddress['name'] }}" @endisset
        @endisset
        @isset($collectShipping) data-collect-shipping="{{ $collectShipping ? 'true' : 'false' }}" @endisset
        @isset($customerData)
            @isset($customerData['email']) data-customer-data:email="{{ $customerData['email'] }}" @endisset
            @isset($customerData['fullName']) data-customer-data:full-name="{{ $customerData['fullName'] }}" @endisset
            @if(isset($customerData['phoneNumber']) && isset($customerData['phoneNumberPrefix']))
                data-customer-data:phone-number="{{ $customerData['phoneNumber'] }}"
                data-customer-data:phone-number-prefix="{{ $customerData['phoneNumberPrefix'] }}"
            @endif
            @if(isset($customerData['legalId']) && isset($customerData['legalIdType']))
                data-customer-data:legal-id="{{ $customerData['legalId'] }}"
                data-customer-data:legal-id-type="{{ $customerData['legalIdType'] }}"
            @endif
        @endisset
        @isset($collectCustomerLegalId) data-collect-customer-legal-id="{{ $collectCustomerLegalId ? 'true' : 'false' }}" @endisset
        @isset($taxInCents)
            @isset($taxInCents['vat']) data-tax-in-cents:vat="{{ $taxInCents['vat'] }}" @endisset
            @isset($taxInCents['consumption']) data-tax-in-cents:consumption="{{ $taxInCents['consumption'] }}" @endisset
        @endisset></script>
    </form>
    <h2>Personalización</h2>
    <p><a href="{{ route('widget-webcheckout.variant.custom', ['variant' => 'widget']) }}">Boton de acceso al widget personalizable</a></p>
  </div>
@endsection
