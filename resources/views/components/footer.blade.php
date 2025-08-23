<footer class="bg-gray-50 dark:bg-[#0a0a0a] border-t border-gray-200 dark:border-white/5">
  <div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
      <div>
        <h3 class="text-gray-600 dark:text-white/70 font-semibold mb-4">Resources</h3>
        <ul class="space-y-3 text-sm">
          @foreach ([
            ['label' => 'Getting Started', 'href' => route('docs.show', ['version' => '2.x', 'page' => 'installation'])],
            ['label' => 'Documentation', 'href' => route('docs')],
            ['label' => 'Examples', 'href' => '/#examples'],
            ['label' => 'Changelog', 'href' => 'https://github.com/laracord/framework/releases']
          ] as $link)
            <li>
              <a
                href="{{ $link['href'] }}"
                class="text-gray-500 dark:text-white/50 dark:hover:text-primary-500 hover:text-primary-500 transition-colors"
              >
                {{ $link['label'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <div>
        <h3 class="text-gray-600 dark:text-white/70 font-semibold mb-4">Community</h3>
        <ul class="space-y-3 text-sm">
          @foreach ([
            ['label' => 'GitHub', 'href' => 'https://github.com/laracord'],
            ['label' => 'Discord', 'href' => 'https://laracord.com/discord'],
            ['label' => 'Twitter', 'href' => 'https://twitter.com/laracordphp'],
          ] as $link)
            <li>
              <a
                target="_blank"
                rel="noopener noreferrer"
                href="{{ $link['href'] }}"
                class="text-gray-500 dark:text-white/50 dark:hover:text-primary-500 hover:text-primary-500 transition-colors"
              >
                {{ $link['label'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <div>
        <h3 class="text-gray-600 dark:text-white/70 font-semibold mb-4">Sponsors</h3>
        <p class="text-gray-500 dark:text-white/50 text-sm mb-4">
          Support Laracord's development and help us build amazing tools for the Laravel community.
        </p>

        <a
          href="https://github.com/sponsors/log1x"
          class="inline-flex items-center gap-2 text-sm font-medium text-primary-500 hover:text-primary-400 transition-colors"
          target="_blank"
          rel="noopener noreferrer"
        >
          <x-lucide-heart class="w-4 h-4" />
          Become a Sponsor
        </a>
      </div>
    </div>

    <div class="border-t text-sm text-gray-500 dark:text-white/50 border-gray-200 dark:border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
      <div class="flex items-center gap-3">
        <svg class="w-auto h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 65">
          <path fill="#E5392A" d="M45 0c-8.6 0-17.2 2.8-24.2 8.4a36.2 36.2 0 0 0-9.7 12h-1A10 10 0 0 0 0 30v12a10 10 0 0 0 10.1 9.8l1-.1 1.3 2.3c1.8 3.2 6.7.5 4.8-2.6a29.8 29.8 0 0 1 7.2-38.9 33 33 0 0 1 41.2 0c12 9.6 15 26 7.2 38.9l-.1.1v.1s-3.9 8-11.3 8H52a4.8 4.8 0 0 0-4-2.1h-6a4.8 4.8 0 0 0-5 4.7c0 1.6 1.1 2.8 3.6 2.8h20.8c11.2 0 16-10.5 16.2-11l1.3-2.4 1 .1A10 10 0 0 0 90 42V30a10 10 0 0 0-10.1-9.7l-1 .1a36 36 0 0 0-9.7-12C62.2 2.8 53.6 0 45 0ZM33.3 17a7 7 0 0 0-5.8 2A26.4 26.4 0 0 0 20 37c0 5.6 2 11.8 5.2 12 4.7.4 12-2.5 20.3-2.5 8.8 0 16.5 3.3 21 2.5 2.9-.5 4.5-6.9 4.5-12 0-6.8-2.9-13.1-7.5-17.8-4.6-4.7-11 0-18 0-4.4 0-8.5-1.8-12.2-2Zm-1.8 12a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Zm27 0a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z"/>
        </svg>

        <span>
          &copy; {{ now()->year }} Laracord. All rights reserved.
        </span>
      </div>
    </div>
  </div>
</footer>
