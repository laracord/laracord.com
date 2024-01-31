<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    {{ seo()->render() }}

    @stack('head')

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-sans text-base leading-normal tracking-normal bg-black/[93%] text-white/80">
    <div>
      {{ $slot }}
    </div>

    @livewireScriptConfig
    @stack('scripts')
  </body>
</html>
