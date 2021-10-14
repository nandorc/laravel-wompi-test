@props(['title' => '', 'icon' => ''])

<head>
  {{-- Metadata --}}
  @stack('before-metadata')
  <x-molecules.head.metadata />
  @stack('after-metadata')
  {{-- Styles --}}
  @stack('before-styles')
  <x-molecules.head.styles />
  @stack('after-styles')
  {{-- Title & Icon --}}
  <title>{{ $title }}</title>
  @if ($icon != '')
    <link rel="shortcut icon" href="{{ $icon }}" />
  @endif
  {{-- Head Scripts --}}
  @stack('before-scripts')
  <x-molecules.head.scripts />
  @stack('after-scripts')
</head>
