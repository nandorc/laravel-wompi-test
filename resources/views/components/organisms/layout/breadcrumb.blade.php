@props(['path' => []])
<ul class="breadcrumb">
  @foreach ($path as $route => $label)
    @if (!$loop->first)
      <li class="divider">/</li>
    @endif
    <li><a href="{{ route($route) }}">{{ $label }}</a></li>
  @endforeach
</ul>
