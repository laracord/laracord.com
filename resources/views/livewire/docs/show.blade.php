<div>
  <x-container class="py-4 md:py-16">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
      <div class="md:-mt-2">
        <a class="ml-1" wire:navigate href="{{ route('home') }}">
          <x-logo />
        </a>

        <nav class="mt-4">
          <ul class="font-mono">
            @foreach ($menu as $group => $items)
              <li class="mt-4 first:mt-0">
                <span class="inline-flex items-center text-sm font-bold transition group">
                  <x-heroicon-m-hashtag class="w-4 h-auto mr-2 text-white/20" />

                  {{ $group }}
                </span>

                @if ($items)
                  <ul class="mt-2 space-y-1">
                    @foreach ($items as $item)
                      <li>
                        <a
                          @class([
                            'text-primary-500' => request()->url() === route('docs.show', [$item['slug']]),
                            'text-white/60 hover:text-primary-500' => request()->url() !== route('docs.show', [$item['slug']]),
                            'text-sm font-medium transition inline-flex items-center group'
                          ])
                          wire:navigate
                          href="{{ route('docs.show', [$item['slug']]) }}"
                        >
                          <x-heroicon-m-chevron-right @class([
                            'w-4 h-auto mr-2',
                            'text-primary-500' => request()->url() === route('docs.show', [$item['slug']]),
                            'opacity-0 group-hover:opacity-100 text-primary-500 transition' => request()->url() !== route('docs.show', [$item['slug']]),
                          ]) />


                          {{ $item['title'] }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </li>
            @endforeach
          </ul>
        </nav>
      </div>

      <div class="col-span-2">
        <h1 class="text-4xl text-primary-500">
          {{ $page->title }}
        </h1>

        <div>
          <div class="mt-8 prose text-white prose-img:shadow prose-img:rounded-lg text-opacity-80 prose-neutral prose-a:text-primary-500 hover:prose-a:text-primary-600 prose-strong:text-primary-500 prose-headings:text-primary-500">
            @markdom($page->content)
          </div>

          <div class="pt-4 mt-6 border-t border-t-white/5">
            <a
              class="text-sm transition-colors text-white/30 hover:text-primary-500"
              href="https://github.com/laracord/laracord.com/blob/main/content/docs/{{ $page->slug }}.md"
            >&rarr; Help us improve this page.</a>
          </div>
        </div>
      </div>
    </div>
  </x-container>

  @pushOnce('scripts')
    @markdomStyles
  @endPushOnce
</div>
