<div>
  <x-container>
    <div class="flex flex-col items-center h-screen pt-16 text-center md:py-8 md:justify-center">
      <x-logo size="5xl" />

      <p class="mt-3 text-lg md:text-xl">
        Create elegant <b>Discord</b> bots with the power of <b>Laravel</b>.
      </p>

      <code
        class="relative px-3 py-2 mt-6 mb-4 text-sm bg-black rounded-lg cursor-pointer"
        x-clipboard.raw="composer create-project laracord/laracord"
        x-tooltip.raw.html="Copy to <span class='text-primary-500'>clipboard</span>."
        x-on:click="$notify('Successfully copied to clipboard.', {
          wrapperId: 'notifications',
          templateId: 'notification-success',
          autoClose: 2000,
          autoRemove: 2500,
        })"
      >
        <span class="text-primary-500">$</span> composer create-project laracord/laracord
      </code>

      <div class="flex items-center justify-center">
        <x-button wire:navigate :url="route('docs.show', ['installation'])">
          Documentation
        </x-button>

        <x-button
          outline
          class="ml-4"
          :url="route('discord')"
          target="_blank"
          rel="noopener noreferrer"
        >
          Join Discord
        </x-button>
      </div>

      <div class="mt-2">
        <a
          href="https://github.com/sponsors/log1x"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center justify-center text-xs tracking-widest transition group text-white/75 hover:scale-105 hover:text-white"
        >
          <x-heroicon-s-heart class="w-3 h-3 mr-1.5 text-red-500 group-hover:animate-pulse" />
          Support the project
        </a>
      </div>
    </div>
  </x-container>
</div>
