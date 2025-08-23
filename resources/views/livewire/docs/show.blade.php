<div class="min-h-screen bg-white dark:bg-[#0a0a0a]"
  x-data="{
    sidebarOpen: false,
    searchOpen: false,
    darkMode: true
  }"
  x-init="
    darkMode = localStorage.getItem('darkMode') !== 'false';
    document.documentElement.classList.toggle('dark', darkMode);

    $watch('darkMode', value => {
      localStorage.setItem('darkMode', value);
      document.documentElement.classList.toggle('dark', value);
    });
  ">
  <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#0a0a0a]/95 backdrop-blur-md border-b border-gray-200 dark:border-[#333333]/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex-shrink-0">
          <a href="{{ route('home') }}" wire:navigate>
            <x-logo size="xl" class="text-black/70 dark:text-white" />
          </a>
        </div>

        <div class="hidden md:flex flex-1 max-w-xl mx-8">
          <x-docs-search :version="$version" class="w-full" />
        </div>

        <div class="flex items-center gap-4">
          <button
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200 dark:hover:bg-[#1a1a1a] transition-colors"
          >
            <x-lucide-menu class="w-5 h-5 text-gray-600 dark:text-white/80" />
          </button>

          <button
            @click="searchOpen = !searchOpen"
            class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200 dark:hover:bg-[#1a1a1a] transition-colors"
          >
            <x-lucide-search class="w-5 h-5 text-gray-600 dark:text-white/80" />
          </button>

          <button
            @click="darkMode = !darkMode"
            class="hidden lg:inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200 dark:hover:bg-[#1a1a1a] transition-colors"
            title="Toggle theme"
          >
            <x-lucide-moon x-show="darkMode" class="w-5 h-5 text-gray-600 dark:text-white/80" />
            <x-lucide-sun x-show="!darkMode" class="w-5 h-5 text-gray-600 dark:text-white/80" />
          </button>

          <div class="relative" x-data="{ open: false }">
            <button
              @click="open = !open"
              @click.away="open = false"
              class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-white/80 hover:text-gray-800 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-[#1a1a1a] rounded-lg transition-all duration-200"
            >
              <span>Version {{ $version }}</span>
              <span :class="{ 'rotate-180': open }" class="transition-transform duration-200">
                <x-lucide-chevron-down class="w-4 h-4" />
              </span>
            </button>

            <div
              x-show="open"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 translate-y-1"
              x-transition:enter-end="opacity-100 translate-y-0"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-start="opacity-100 translate-y-0"
              x-transition:leave-end="opacity-0 translate-y-1"
              class="absolute top-full right-0 mt-2 w-32 bg-white dark:bg-[#1a1a1a] border border-gray-300 dark:border-[#333333]/50 rounded-xl shadow-2xl overflow-hidden"
            >
              <div class="py-2">
                <a
                  href="{{ route('docs.show', ['version' => '2.x', 'page' => $page->slug]) }}"
                  wire:navigate
                  @class([
                    'block px-4 py-2.5 text-sm transition-colors',
                    'text-primary-500 bg-primary-500/10' => $version === '2.x',
                    'text-gray-600 dark:text-white/70 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#2a2a2a]' => $version !== '2.x',
                  ])
                >
                  Version 2.x
                </a>
              </div>
            </div>
          </div>

          <a
            href="https://github.com/laracord/laracord"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200 dark:hover:bg-[#1a1a1a] transition-colors"
          >
            <x-lucide-github class="w-5 h-5 text-gray-600 dark:text-white/80" />
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 lg:hidden"
    @click="sidebarOpen = false"
  >
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-16 left-0 bottom-0 z-50 w-80 bg-white dark:bg-[#0a0a0a] border-r border-gray-300 dark:border-[#333333]/50 lg:hidden"
  >
    <div class="h-full overflow-y-auto p-6 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-300 dark:scrollbar-thumb-white/10 hover:scrollbar-thumb-gray-400 dark:hover:scrollbar-thumb-white/20">
      <nav>
        <ul class="space-y-6 pb-8">
          @foreach ($menu as $group => $items)
            <li>
              <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-white/40 mb-3">
                {{ $group }}
              </h3>

              @if ($items)
                <ul class="space-y-1">
                  @foreach ($items as $item)
                    <li>
                      <a
                        @class([
                          'block px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
                          'bg-primary-500/10 text-primary-500' => request()->url() === route('docs.show', ['version' => $version, 'page' => $item['slug']]),
                          'text-gray-600 dark:text-white/70 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1a1a1a]' => request()->url() !== route('docs.show', ['version' => $version, 'page' => $item['slug']]),
                        ])
                        wire:navigate
                        href="{{ route('docs.show', ['version' => $version, 'page' => $item['slug']]) }}"
                        @click="sidebarOpen = false"
                      >
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

      <div class="mt-3 pt-3 border-t border-gray-200 dark:border-[#333333]/50">
        <button
          @click="darkMode = !darkMode"
          class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-white/70 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1a1a1a] rounded-lg transition-colors"
          title="Toggle theme"
        >
          <x-lucide-moon x-show="darkMode" class="w-4 h-4" />
          <x-lucide-sun x-show="!darkMode" class="w-4 h-4" />
          <span x-show="darkMode">Dark mode</span>
          <span x-show="!darkMode">Light mode</span>
        </button>
      </div>
    </div>
  </aside>

  <div
    x-show="searchOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 md:hidden"
    @click="searchOpen = false"
  >
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <div
    x-show="searchOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed top-16 left-0 right-0 z-50 bg-white dark:bg-[#0a0a0a] border-b border-gray-200 dark:border-[#333333]/50 md:hidden"
  >
    <div class="p-4">
      <x-docs-search :version="$version" />
    </div>
  </div>

  <div class="pt-16">
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-16">
      <div class="grid grid-cols-1 gap-y-8 lg:gap-x-8 lg:grid-cols-4">
        <div class="hidden lg:block lg:col-span-1">
          <div class="sticky top-24 h-[calc(100vh-6rem)] overflow-y-auto pr-2 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-300 dark:scrollbar-thumb-white/10 hover:scrollbar-thumb-gray-400 dark:hover:scrollbar-thumb-white/20">
            <nav>
              <ul class="space-y-6 pb-8">
                @foreach ($menu as $group => $items)
                  <li>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-white/40 mb-3">
                      {{ $group }}
                    </h3>

                    @if ($items)
                      <ul class="space-y-1">
                        @foreach ($items as $item)
                          <li>
                            <a
                              @class([
                                'block px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
                                'bg-primary-500/10 text-primary-500' => request()->url() === route('docs.show', ['version' => $version, 'page' => $item['slug']]),
                                'text-gray-600 dark:text-white/70 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1a1a1a]' => request()->url() !== route('docs.show', ['version' => $version, 'page' => $item['slug']]),
                              ])
                              wire:navigate
                              href="{{ route('docs.show', ['version' => $version, 'page' => $item['slug']]) }}"
                            >
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
        </div>

        <div class="lg:col-span-2">
          <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold text-primary-500 mb-2">
              {{ $page->title }}
            </h1>

            <div
              class="lg:hidden mb-8 mt-6"
              x-data="tableOfContents()"
              x-init="generateToc()"
            >
              <div x-show="headings.length > 0" class="bg-gray-50 dark:bg-[#1a1a1a] rounded-lg p-4 border border-gray-200 dark:border-[#333333]/50">
                <h3 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-3">
                  <x-lucide-list class="w-4 h-4 opacity-60" />
                  On this page
                </h3>

                <nav>
                  <ul class="space-y-1 text-sm">
                    <template x-for="heading in headings" :key="heading.id">
                      <li>
                        <a
                          :href="'#' + heading.id"
                          @click.prevent="scrollToHeading(heading.id)"
                          :class="{
                            'text-primary-500 dark:text-primary-400': activeHeading === heading.id,
                            'text-gray-600 dark:text-white/70': activeHeading !== heading.id,
                            'pl-4': heading.level > 2
                          }"
                          class="flex items-center gap-2 py-1 hover:text-primary-500 dark:hover:text-primary-400 transition-colors"
                        >
                          <span class="text-orange-500 font-mono text-xs">#</span>
                          <span x-text="heading.text"></span>
                        </a>
                      </li>
                    </template>
                  </ul>
                </nav>
              </div>
            </div>

            <div id="content" class="prose prose-lg max-w-none
              prose-headings:text-gray-900 dark:prose-headings:text-white prose-headings:font-bold
              prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6
              prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
              prose-p:text-gray-700 dark:prose-p:text-white/80 prose-p:leading-relaxed
              prose-a:text-primary-500 prose-a:no-underline prose-a:font-medium prose-a:transition-colors prose-a:hover:text-primary-400
              prose-strong:text-gray-900 dark:prose-strong:text-white prose-strong:font-semibold
              prose-code:text-white prose-code:bg-[#121212] prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:font-normal prose-code:before:content-[''] prose-code:after:content-['']
              prose-pre:bg-[#121212] prose-pre:text-white prose-pre:border-0 prose-pre:shadow-xl
              prose-ul:text-gray-700 dark:prose-ul:text-white/80 prose-li:text-gray-700 dark:prose-li:text-white/80
              prose-blockquote:text-gray-700 dark:prose-blockquote:text-white/70 prose-blockquote:border-l-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-[#1a1a1a] prose-blockquote:py-3 prose-blockquote:px-6 prose-blockquote:rounded-lg
              [&_blockquote]:!text-gray-700 dark:[&_blockquote]:!text-white/70 [&_blockquote]:!bg-blue-50 dark:[&_blockquote]:!bg-[#1a1a1a] [&_blockquote]:!border-l-blue-500
              [&_blockquote_h4]:!text-blue-600 dark:[&_blockquote_h4]:!text-blue-400 [&_blockquote_strong]:!text-blue-600 dark:[&_blockquote_strong]:!text-blue-400
              [&_blockquote_a]:!text-blue-600 dark:[&_blockquote_a]:!text-blue-400
              prose-img:rounded-xl prose-img:shadow-2xl prose-img:border prose-img:border-gray-200 dark:prose-img:border-[#333333]/50"
            >
              @markdom($page->content)
            </div>

            <div class="mt-16 pt-8 border-t border-gray-200 dark:border-[#333333]/25">
              <a
                class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-white/50 dark:hover:text-primary-500 hover:text-primary-500 transition-colors group"
                href="https://github.com/laracord/laracord.com/blob/main/content/docs/{{ $version }}/{{ $page->slug }}.md"
                target="_blank"
                rel="noopener noreferrer"
              >
                <x-lucide-github class="w-4 h-4" />
                <span>Help us improve this page</span>
                <x-lucide-arrow-up-right class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
              </a>
            </div>
          </div>
        </div>

        <div class="hidden lg:block lg:col-span-1"
          x-data="tableOfContents()"
          x-init="generateToc()"
        >
          <div class="sticky top-24 h-[calc(100vh-6rem)] overflow-y-auto pl-6 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-300 dark:scrollbar-thumb-white/10 hover:scrollbar-thumb-gray-400 dark:hover:scrollbar-thumb-white/20">
            <div x-show="headings.length > 0" class="space-y-4">
              <h3 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">
                <x-lucide-list class="w-4 h-4 opacity-60" />
                On this page
              </h3>

              <nav>
                <ul class="space-y-1 text-sm">
                  <template x-for="heading in headings" :key="heading.id">
                    <li>
                      <a
                        :href="'#' + heading.id"
                        @click.prevent="scrollToHeading(heading.id)"
                        :class="{
                          'text-primary-500 dark:text-primary-400': activeHeading === heading.id,
                          'text-gray-600 dark:text-white/70': activeHeading !== heading.id,
                          'pl-4': heading.level > 2
                        }"
                        class="block py-1 hover:text-primary-500 dark:hover:text-primary-400 transition-colors"
                        x-text="heading.text"
                      ></a>
                    </li>
                  </template>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-footer />

  @pushOnce('scripts')
    @markdomStyles

    <script>
      function tableOfContents() {
        return {
          headings: [],
          activeHeading: null,
          observer: null,

          generateToc() {
            const content = document.getElementById('content');

            if (!content) return;

            const headingElements = content.querySelectorAll('h2, h3');

            this.headings = Array.from(headingElements).map((heading, index) => {
              const level = parseInt(heading.tagName.charAt(1));
              const text = heading.textContent.trim().replace(/^#+\s*/, '');
              const id = heading.id || `heading-${index}`;

              if (!heading.id) {
                heading.id = id;
              }

              return { id, text, level, element: heading };
            });

            this.$nextTick(() => {
              this.setupIntersectionObserver();
            });
          },

          scrollToHeading(id) {
            const element = document.getElementById(id);

            if (element) {
              element.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
              });
            }
          },

          setupIntersectionObserver() {
            if (this.observer) {
              this.observer.disconnect();
            }

            this.observer = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                if (entry.isIntersecting) {
                  this.activeHeading = entry.target.id;
                }
              });
            }, {
              rootMargin: '-10% 0% -85% 0%',
              threshold: 0.1
            });

            this.headings.forEach(heading => {
              if (heading.element) {
                this.observer.observe(heading.element);
              }
            });
          }
        }
      }
    </script>
  @endPushOnce
</div>
