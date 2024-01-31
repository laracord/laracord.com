@props([
  'label' => null,
  'url' => null,
  'tag' => 'button',
  'size' => 'sm',
  'color' => 'primary',
  'icon' => null,
  'iconRight' => null,
  'outline' => false,
])

@php($iconSize = match ($size) {
  'xs' => 'w-3 h-3',
  'sm' => 'w-4 h-4',
  'md' => 'w-5 h-5',
  'lg' => 'w-6 h-6',
  default => 'w-4 h-4',
})

@php($size = match ($size) {
  'xs' => 'text-xs px-2.5 py-1.5',
  'sm' => 'text-sm px-3 py-2',
  'md' => 'text-base px-4 py-2',
  'lg' => 'text-lg px-6 py-3',
  default => 'text-base px-4 py-2',
})

@if ($outline)
  @php($color = match ($color) {
    'primary' => 'border border-primary-500 hover:bg-primary-600 text-primary-500 hover:text-white',
    'green' => 'border border-green-500 hover:bg-green-600 text-green-500 hover:text-white',
    'gray' => 'border border-gray-500 hover:bg-gray-600 text-gray-600 hover:text-white',
    default => 'border border-primary-500 hover:bg-primary-600 text-primary-500 hover:text-white',
  })
@else
  @php($color = match ($color) {
    'primary' => 'bg-primary-500 hover:bg-primary-600 text-white',
    'green' => 'bg-green-500 hover:bg-green-500 text-white',
    'gray' => 'bg-gray-500 hover:bg-gray-500 text-white',
    default => 'bg-primary-500 hover:bg-primary-600 text-white',
  })
@endif

@php($tag = $url ? 'a' : $tag)

@if ($url)
  @php($attributes = $attributes->merge(['href' => $url]))
@endif

<{{ $tag }} {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-md transition hover:scale-[103%] {$size} {$color}"]) }}>
  @if ($icon)
    <x-icon :name="$icon" class="{{ $iconSize }} mr-2" />
  @endif

  <span>{{ $label ?? $slot }}</span>

  @if ($iconRight)
    <x-icon :name="$iconRight" class="{{ $iconSize }} ml-2" />
  @endif
</{{ $tag }}>
