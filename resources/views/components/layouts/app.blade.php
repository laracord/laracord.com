<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    {{ seo()->render() }}

    @stack('head')

    @preloadFonts
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-sans text-base leading-normal tracking-normal bg-black/[93%] text-white/80">
    <div>
      {{ $slot }}
    </div>

    @livewireScriptConfig
    @stack('scripts')

    @production
      <script src="https://cdn.usefathom.com/script.js" data-site="TCWDOMUK" data-spa="auto" defer></script>
    @endproduction
  </body>
</html>
