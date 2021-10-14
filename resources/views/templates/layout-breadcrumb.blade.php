@php
$path = array_merge(['welcome' => 'Inicio'], $path ?? []);
@endphp
@extends('templates.layout')
@section('body__content')
  <x-organisms.layout.breadcrumb :path="$path" />
  <section>@yield('section__content')</section>
@endsection
