@extends('templates.layout-breadcrumb')
@section('head__title', 'Widget Personalizado')
@push('head__after-scripts')
  <script type="text/javascript" src="https://checkout.wompi.co/widget.js"></script>
@endpush
@section('section__content')
  <h2>Información para el pago</h2>
  <table>
    <tr>
      <td>Referencia de pago:</td>
      <td>{{ $reference ?? '' }}</td>
    </tr>
  </table>
  <h2>Botón de Pago</h2>
  <button class="wompi__pay-button" type="button">Pagar</button>
@endsection
@push('body__before-scripts')
  <script>
    const WompiWidget = {
      buildWidgetData: () => {
        const data = {}
        data.publicKey = "{{ $publicKey ?? '' }}"
        data.currency = "{{ $currency ?? '' }}"
        data.amountInCents = parseInt("{{ $amountInCents ?? 0 }}")
        data.reference = "{{ $reference ?? '' }}"
        @isset($redirectUrl)
          data.redirectUrl = "{{ $redirectUrl }}"
        @endisset
        @isset($shippingAddress)
          const shippingAddress = {}
          shippingAddress.addressLine1 = "{{ $shippingAddress['addressLine1'] ?? '' }}"
          @isset($shippingAddress['addressLine2'])
            shippingAddress.addressLine2 = "{{ $shippingAddress['addressLine2'] }}"
          @endisset
          shippingAddress.country = "{{ $shippingAddress['country'] ?? '' }}"
          shippingAddress.city = "{{ $shippingAddress['city'] ?? '' }}"
          shippingAddress.phoneNumber = "{{ $shippingAddress['phoneNumber'] ?? '' }}"
          shippingAddress.region = "{{ $shippingAddress['region'] ?? '' }}"
          @isset($shippingAddress['name'])
            shippingAddress.name = "{{ $shippingAddress['name'] }}"
          @endisset
          data.shippingAddress = shippingAddress
        @endisset
        @if (isset($collectShipping) && $collectShipping)
          data.collectShipping = "true"
        @endif
        @isset($customerData)
          const customerData = {}
          @isset($customerData['email'])
            customerData.email = "{{ $customerData['email'] }}"
          @endisset
          @isset($customerData['fullName'])
            customerData.fullName = "{{ $customerData['fullName'] }}"
          @endisset
          @if (isset($customerData['phoneNumber']) && isset($customerData['phoneNumberPrefix']))
            customerData.phoneNumber = "{{ $customerData['phoneNumber'] }}"
            customerData.phoneNumberPrefix = "{{ $customerData['phoneNumberPrefix'] }}"
          @endif
          @if (isset($customerData['legalId']) && isset($customerData['legalIdType']))
            customerData.legalId = "{{ $customerData['legalId'] }}"
            customerData.legalIdType = "{{ $customerData['legalIdType'] }}"
          @endif
          data.customerData = customerData
        @endisset
        @if (isset($collectCustomerLegalId) && $collectCustomerLegalId)
          data.collectCustomerLegalId = "true"
        @endif
        @isset($taxInCents)
          const taxInCents = {}
          @isset($taxInCents['vat'])
            taxInCents.vat = parseInt("{{ $taxInCents['vat'] }}")
          @endisset
          @isset($taxInCents['consumption'])
            taxInCents.consumption = parseInt("{{ $taxInCents['consumption'] }}")
          @endisset
          data.taxInCents = taxInCents
        @endisset
        return data
      },
      setupPayButton: (widget) => {
        const payButton = document.querySelector('.wompi__pay-button')
        if (payButton instanceof HTMLButtonElement) {
          payButton.addEventListener('click', () => widget.open(WompiWidget.handleResult))
        }
      },
      handleResult: (result) => {
        console.log(result)
      },
      init: () => {
        const widget = new WidgetCheckout(WompiWidget.buildWidgetData())
        WompiWidget.setupPayButton(widget)
      }
    }
    document.addEventListener('DOMContentLoaded', WompiWidget.init)
  </script>
@endpush
