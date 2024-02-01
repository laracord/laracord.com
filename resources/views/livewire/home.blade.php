<div>
  <x-container>
    <div class="flex flex-col items-center h-screen py-8 text-center md:py-0 md:justify-center">
      <x-logo size="5xl" />

      <p class="mt-3 text-xl">Create elegant <b>Discord</b> bots with the power of <b>Laravel</b>.</p>

      <code class="px-3 py-2 my-6 text-sm bg-black rounded-lg">
        <span class="text-primary-500">$</span> composer create-project laracord/laracord
      </code>

      <div class="flex items-center justify-center">
        <x-button wire:navigate url="{{ route('docs.show', ['installation']) }}">
          Documentation
        </x-button>

        <x-button
          outline
          class="ml-4"
          url="https://github.com/laracord/laracord"
          target="_blank"
          rel="noopener noreferrer"
        >
          View on GitHub
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
