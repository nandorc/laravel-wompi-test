@extends('templates.layout')
@section('body__content')
  <x-organisms.layout.breadcrumb :path="$breadcrumb ?? []" />
  <section>@yield('section__content')</section>
@endsection
