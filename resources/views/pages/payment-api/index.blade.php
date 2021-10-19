@extends('templates.layout-breadcrumb')
@section('head__title', 'API de Pagos')
@section('section__content')
  <ul>
    <li><a href="{{ route('payment-api.acceptance-token') }}">Token de aceptación</a></li>
    <li>
      Métodos de pago
      <ul>
        <li><a href="{{ route('payment-api.payment-methods.card') }}">Pago por tarjeta</a></li>
      </ul>
    </li>
  </ul>
@endsection
