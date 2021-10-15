@props(['path' => []])
<ul class="breadcrumb">
  @foreach ($path as $breadcrumb)
    @if (!$loop->first)
      <li class="divider">/</li>
    @endif
    <li><a href="{{ route($breadcrumb['route'], $breadcrumb['params'] ?? []) }}">{{ $breadcrumb['label'] }}</a></li>
  @endforeach
</ul>
