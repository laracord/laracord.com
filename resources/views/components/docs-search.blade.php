<div
  {{ $attributes->merge(['class' => 'relative']) }}
  x-data="search()"
  @click.away="reset()"
  @keydown.escape="reset()"
>
  <div class="relative flex items-center max-w-64">
    <input
      class="w-full py-2 pl-4 text-sm border-black rounded-lg pr-7 text-white/75 placeholder:text-white/50 bg-black/25 focus:ring-0 focus:outline-none focus:border-primary-500"
      placeholder="{{ $placeholder }}"
      x-on:input.debounce.300="get()"
      x-model="query"
      name="query"
    />

    <button type="submit" class="absolute right-0 mr-2 transition-colors text-white/30 hover:text-primary-500">
      <x-heroicon-o-magnifying-glass class="w-4 h-auto" />
    </button>
  </div>

  <template x-if="isFocused">
    <div class="absolute inset-x-0 z-10 w-full pr-6 mt-3 text-base text-white top-full">
      <ul class="w-full px-5 py-4 overflow-hidden border border-b-4 border-white rounded shadow border-opacity-[3%] bg-[#141414] border-b-primary-500/100">
        <div class="text-xs tracking-wide uppercase text-white/50">
          Showing <span x-text="count"></span> of <span x-text="total"></span> results
        </div>

        <li x-show="count == 0" class="w-full py-2 my-2 -mb-2 text-sm">
          No results found
        </li>

        <template x-for="result in results" :key="result.slug">
          <li class="flex items-center w-full border-b border-white last:-mb-4 border-opacity-10 last:border-0">
            <a @click="reset()" class="block py-2 my-2 group" :href="result.url" wire:navigate>
              <div class="mb-1 text-sm transition-colors group-hover:text-primary-500" x-html="result.title"></div>
              <div class="text-xs text-white/50" x-html="result.content"></div>
            </a>
          </li>
        </template>
      </ul>
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

            fetch(`{!! $endpoint !!}?query=${this.query}`)
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
