<!DOCTYPE html>
<html class="dark scrollbar scrollbar-thumb-white/10 scrollbar-track-black/25 scrollbar-corner-black/25" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    {{ seo()->render() }}

    @stack('head')

    @preloadFonts
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-sans text-base leading-normal tracking-normal bg-black/[93%] text-white/80">
    <div class="absolute top-6 right-6">
      <a
        aria-label="View project on GitHub"
        rel="noopener noreferrer"
        target="_blank"
        class="transition-colors text-white/50 hover:text-white"
        href="https://github.com/laracord/laracord"
      >
        @svg('github', 'w-5 h-auto fill-current')
      </a>
    </div>

    <div>
      {{ $slot }}
    </div>

    <div
      id="notifications"
      class="fixed right-0 space-y-2 bottom-4 md:bottom-auto md:w-72 md:top-4"
    ></div>

    <template id="notification-success">
      <div role="alert" class="relative data-[notify-show=true]:animate-slide-in data-[notify-show=false]:animate-slide-out">
        <div class="px-4 py-3 mr-4 text-white border rounded-lg shadow bg-black/40 border-black/60">
          <div class="flex items-start">
            <x-heroicon-o-check-circle class="inline-block w-5 h-auto mr-2 text-green-600" />

            <div>
              <div class="mb-1 text-sm">Success</div>
              <div class="text-xs text-white/50">{notificationText}</div>
            </div>
          </div>
        </div>
      </div>
    </template>

    @livewireScriptConfig
    @stack('scripts')

    @production
      <script src="https://cdn.usefathom.com/script.js" data-site="TCWDOMUK" data-auto="false" defer></script>

      <script>
        document.addEventListener('livewire:navigated', () => window.fathom && window.fathom.trackPageview());
      </script>
    @endproduction
  </body>
</html>
