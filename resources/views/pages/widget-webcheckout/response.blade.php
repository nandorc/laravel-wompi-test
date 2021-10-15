@extends('templates.layout-breadcrumb')
@section('head__title', 'Confirmación de Pago')
@section('section__content')
  Confirmación de pago
  <pre>{{ $result ?? '' }}</pre>
@endsection
