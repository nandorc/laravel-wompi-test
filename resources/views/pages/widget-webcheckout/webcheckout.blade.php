@extends('templates.layout-breadcrumb')
@section('head__title', 'WebCheckout')
@section('section__content')
  <form action="https://checkout.wompi.co/p/" method="GET">
    <input type="hidden" name="public-key" value="{{ $publicKey ?? '' }}" />
    <input type="hidden" name="currency" value="{{ $currency ?? '' }}" />
    <input type="hidden" name="amount-in-cents" value="{{ $amountInCents ?? '' }}" />
    <input type="hidden" name="reference" value="{{ $reference ?? '' }}" />
    @isset($redirectUrl) <input type="hidden" name="redirect-url" value="{{ $redirectUrl }}" /> @endisset
    @isset($shippingAddress)
      <input type="hidden" name="shipping-address:address-line-1" value="{{ $shippingAddress['addressLine1'] ?? '' }}" />
      @isset($shippingAddress['addressLine2']) <input type="hidden" name="shipping-address:address-line-2"
        value="{{ $shippingAddress['addressLine2'] }}" /> @endisset
      <input type="hidden" name="shipping-address:country" value="{{ $shippingAddress['country'] ?? '' }}" />
      <input type="hidden" name="shipping-address:city" value="{{ $shippingAddress['city'] ?? '' }}" />
      <input type="hidden" name="shipping-address:phone-number" value="{{ $shippingAddress['phoneNumber'] ?? '' }}" />
      <input type="hidden" name="shipping-address:region" value="{{ $shippingAddress['region'] ?? '' }}" />
      @isset($shippingAddress['name']) <input type="hidden" name="shipping-address:name"
        value="{{ $shippingAddress['name'] }}" /> @endisset
    @endisset
    @isset($collectShipping) <input type="hidden" name="collect-shipping"
      value="{{ $collectShipping ? 'true' : 'false' }}" /> @endisset
    @isset($customerData)
      @isset($customerData['email']) <input type="hidden" name="customer-data:email"
        value="{{ $customerData['email'] }}" /> @endisset
      @isset($customerData['fullName']) <input type="hidden" name="customer-data:full-name"
        value="{{ $customerData['fullName'] }}" /> @endisset
      @if (isset($customerData['phoneNumber']) && isset($customerData['phoneNumberPrefix']))
        <input type="hidden" name="customer-data:phone-number" value="{{ $customerData['phoneNumber'] }}" />
        <input type="hidden" name="customer-data:phone-number-prefix" value="{{ $customerData['phoneNumberPrefix'] }}" />
      @endif
      @if (isset($customerData['legalId']) && isset($customerData['legalIdType']))
        <input type="hidden" name="customer-data:legal-id" value="{{ $customerData['legalId'] }}" />
        <input type="hidden" name="customer-data:legal-id-type" value="{{ $customerData['legalIdType'] }}" />
      @endif
    @endisset
    @isset($collectCustomerLegalId) <input type="hidden" name="collect-customer-legal-id"
      value="{{ $collectCustomerLegalId ? 'true' : 'false' }}" /> @endisset
    @isset($taxInCents)
      @isset($taxInCents['vat']) <input type="hidden" name="tax-in-cents:vat" value="{{ $taxInCents['vat'] }}" />
      @endisset
      @isset($taxInCents['consumption']) <input type="hidden" name="tax-in-cents:consumption"
        value="{{ $taxInCents['consumption'] }}" /> @endisset
    @endisset
    <button type="submit">Pagar con Wompi</button>
  </form>
@endsection
