<div>
  <x-container class="py-4 md:py-16">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
      <div>
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
                            'text-gray-400 hover:text-primary-500' => request()->url() !== route('docs.show', [$item['slug']]),
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
          <div class="mt-8 prose text-white text-opacity-80 prose-neutral prose-a:text-orange-500 hover:prose-a:text-orange-600 prose-strong:text-orange-500 prose-headings:text-primary-500">
            @markdom($page->content)
          </div>
        </div>
      </div>
    </div>
  </x-container>

  @pushOnce('head')
    @markdomStyles
  @endPushOnce
</div>
