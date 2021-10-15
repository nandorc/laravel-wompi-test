@extends('templates.layout-breadcrumb')
@section('head__title', 'Wiget y WebCheckout')
@section('section__content')
  <p>WOMPI ofrece dos opciones para el Checkout</p>
  <ul>
    <li><a href="{{ route('widget-webcheckout.widget') }}">Widget</a></li>
    <li><a href="">WebCheckout</a></li>
  </ul>
@endsection
