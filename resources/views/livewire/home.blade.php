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

        <x-button outline class="ml-4" url="https://github.com/laracord/laracord" target="_blank">
          View on GitHub
        </x-button>
      </div>
    </div>
  </x-container>
</div>
