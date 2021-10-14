@php
$defaultTitle = 'Pruebas WOMPI';
$isDarkTheme = isset($theme) && $theme == 'dark';
@endphp
<!DOCTYPE html>
<html lang="es">

<x-organisms.layout.head>
  {{-- Feed head stacks --}}
  @push('before-metadata')@stack('head__before-metadata')@endpush
  @push('after-metadata')@stack('head__after-metadata')@endpush
  @push('before-styles')@stack('head__before-styles')@endpush
  @push('after-styles')@stack('head__after-styles')@endpush
  @push('before-scripts')@stack('head__before-scripts')@endpush
  @push('after-scripts')@stack('head__after-scripts')@endpush
  {{-- Set page title --}}
  <x-slot name='title'>
    @hasSection('head__title')
      {{ $defaultTitle }} - @yield('head__title')
    @else
      {{ $defaultTitle }}
    @endif
  </x-slot>
  {{-- Set page icon --}}
  <x-slot name='icon'>
    @if ($isDarkTheme)
      @yield('head__icon--dark','/favicon--dark-theme.ico')
    @else
      @yield('head__icon','/favicon.ico')
    @endif
  </x-slot>
</x-organisms.layout.head>

<body @if ($isDarkTheme)class='dark'@endif>
  <x-organisms.layout.header />
  <x-organisms.layout.navigation />
  <x-organisms.layout.main>@yield('body__content')</x-organisms.layout.main>
  <x-organisms.layout.footer />
  @stack('body__before-scripts')
  <x-molecules.body.scripts />
  @stack('body__after-scripts')
</body>

</html>
