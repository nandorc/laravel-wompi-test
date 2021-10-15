@extends('templates.layout-breadcrumb')
@section('head__title', 'Wiget y WebCheckout')
@section('section__content')
  <p>WOMPI ofrece dos opciones para el Checkout</p>
  <ul>
    <li><a href="{{ route('widget-webcheckout.variant', ['variant' => 'widget']) }}">Widget</a></li>
    <li><a href="{{ route('widget-webcheckout.variant', ['variant' => 'webcheckout']) }}">WebCheckout</a></li>
  </ul>
@endsection
