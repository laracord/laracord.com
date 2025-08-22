<div
  {{ $attributes->merge(['class' => 'relative']) }}
  x-data="search()"
  @click.away="reset()"
  @keydown.escape="reset()"
>
  <div class="relative flex items-center w-full">
    <input
      class="w-full py-3 pl-4 text-sm border border-[#333333]/50 rounded-lg pr-12 text-white/80 placeholder:text-white/50 bg-[#1a1a1a]/80 focus:ring-0 focus:outline-none focus:border-primary-500 transition-colors"
      placeholder="{{ $placeholder }}"
      x-on:input.debounce.300="get()"
      x-model="query"
      name="query"
    />

    <div class="absolute right-4 transition-colors text-white/40">
      <x-heroicon-o-magnifying-glass class="w-4 h-auto" />
    </div>
  </div>

  <template x-if="isFocused">
    <div class="absolute inset-x-0 z-10 w-full mt-2 text-base text-white top-full">
      <div class="bg-[#1a1a1a] border border-[#333333]/50 rounded-xl shadow-2xl overflow-hidden">
        <div class="px-4 py-3 border-b border-[#333333]/50 bg-[#1a1a1a]/50">
          <div class="text-xs font-medium text-white/60">
            Showing <span x-text="count" class="text-white/80"></span> of <span x-text="total" class="text-white/80"></span> results
          </div>
        </div>

        <div class="max-h-80 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-white/10">
          <div x-show="count == 0" class="px-4 py-6 text-sm text-white/60 text-center">
            No results found
          </div>

          <template x-for="result in results" :key="result.slug">
            <div class="border-b border-[#333333]/30 last:border-0">
              <a @click="reset(); if (window.Alpine && $store.docs) $store.docs.closeSearch()" class="block px-4 py-3 hover:bg-[#2a2a2a] transition-colors group" :href="result.url" wire:navigate>
                <div class="flex items-start justify-between mb-1">
                  <div class="text-sm font-medium text-white group-hover:text-primary-500 transition-colors" x-html="result.title"></div>
                  <div class="text-xs text-white/40 ml-2 flex-shrink-0" x-text="result.group"></div>
                </div>
                <div class="text-xs text-white/60 leading-relaxed" x-html="result.content"></div>
              </a>
            </div>
          </template>
        </div>
      </div>
    </div>
  </template>

  @push('scripts')
    <script>
      function search() {
        return {
          query: null,
          results: [],
          count: 0,
          total: 0,
          isLoading: false,
          isFocused: false,

          get() {
            if (this.query.length <= {{ $minLength }}) {
              return this.reset();
            }

            this.isFocused = true;
            this.isLoading = true;

            fetch(`{!! $endpoint !!}?query=${this.query}&version={{ $version }}`)
              .then(res => res.status === 200 ? res.json() : [])
              .then(res => {
                this.isLoading = false;
                this.count = res.count || 0;
                this.total = res.total || 0;
                this.results = res.results || [];
              })
          },
          reset() {
            this.isFocused = false;
            this.count = 0;
            this.total = 0;
            this.results = [];
          }
        }
      }
    </script>
  @endpush
</div>
