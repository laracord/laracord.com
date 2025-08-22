@use('Phiki\Phiki')
@use('Phiki\Grammar\Grammar')
@use('Phiki\Theme\Theme')

<div class="min-h-screen bg-[#0a0a0a]" x-data="{
  mobileMenuOpen: false,
  init() {
    this.$watch('mobileMenuOpen', value => document.body.style.overflow = value ? 'hidden' : '');
  }
}">
  <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-[#333333]/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <a href="{{ route('home') }}" wire:navigate>
              <x-logo size="xl" />
            </a>
          </div>
        </div>

        <div class="hidden lg:block">
          <div class="ml-10 flex items-baseline space-x-8">
            @foreach ([
              ['href' => '#features', 'label' => 'Features'],
              ['href' => '#examples', 'label' => 'Examples'],
              ['href' => '#getting-started', 'label' => 'Get Started'],
              ['href' => '#faq', 'label' => 'FAQ']
            ] as $item)
              <a
                href="{{ $item['href'] }}"
                class="text-white/80 hover:text-primary-500 transition-colors px-3 py-2 text-sm font-medium"
              >
                {{ $item['label'] }}
              </a>
            @endforeach
          </div>
        </div>

        <div class="hidden lg:flex items-center space-x-4">
          <a
            href="https://github.com/laracord/laracord"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent dark:hover:bg-accent/50 h-8 rounded-md gap-1.5 px-3 text-white/80 hover:text-primary-500"
          >
            <x-lucide-github class="w-4 h-4" />
            GitHub
          </a>

          <a
            href="{{ route('docs') }}"
            wire:navigate
            class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive shadow-xs h-8 rounded-md gap-1.5 px-3 bg-primary-500 hover:bg-primary-500/90 text-white"
          >
            Documentation
            <x-lucide-external-link class="w-4 h-4" />
          </a>
        </div>

        <div class="lg:hidden">
          <button
            @click="mobileMenuOpen = true"
            class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent dark:hover:bg-accent/50 h-8 rounded-md gap-1.5 px-3 text-white/80 hover:text-primary-500"
          >
            <x-lucide-menu class="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>
  </nav>

  <div
    x-show="mobileMenuOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="mobileMenuOpen = false"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] lg:hidden"
  ></div>

  <div
    x-show="mobileMenuOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    @click.away="mobileMenuOpen = false"
    class="fixed right-0 top-0 bottom-0 w-[280px] bg-[#0a0a0a] border-l border-[#333333]/50 z-[101] lg:hidden overflow-y-auto"
  >
    <div class="p-6">
      <div class="flex justify-between items-center mb-8">
        <x-logo size="lg" />
        <button
          @click="mobileMenuOpen = false"
          class="inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-[#1a1a1a] transition-colors"
        >
          <x-lucide-x class="w-5 h-5 text-white/80" />
        </button>
      </div>

      <nav class="space-y-1 mb-8">
        @foreach ([
          ['href' => '#features', 'label' => 'Features', 'icon' => 'sparkles'],
          ['href' => '#examples', 'label' => 'Examples', 'icon' => 'code-2'],
          ['href' => '#getting-started', 'label' => 'Get Started', 'icon' => 'rocket'],
          ['href' => '#faq', 'label' => 'FAQ', 'icon' => 'help-circle']
        ] as $item)
          <a
            href="{{ $item['href'] }}"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-[#1a1a1a] transition-all duration-200 group"
          >
            <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-5 h-5 text-white/60 group-hover:text-primary-500 transition-colors" />
            <span class="font-medium">{{ $item['label'] }}</span>
          </a>
        @endforeach
      </nav>

      <div class="border-t border-[#333333]/50 mb-8"></div>

      <div class="space-y-3">
        <a
          href="{{ route('docs') }}"
          wire:navigate
          class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-primary-500 hover:bg-primary-500/90 text-white rounded-lg font-medium transition-all duration-200 shadow-lg shadow-primary-500/25"
        >
          <x-lucide-book-open class="w-4 h-4" />
          Documentation
        </a>

        <a
          href="https://github.com/laracord/laracord"
          target="_blank"
          rel="noopener noreferrer"
          class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-[#1a1a1a] hover:bg-[#2a2a2a] text-white/80 hover:text-white border border-[#333333]/50 rounded-lg font-medium transition-all duration-200"
        >
          <x-lucide-github class="w-4 h-4" />
          View on GitHub
        </a>
      </div>

      <div class="mt-8 pt-8 border-t border-[#333333]/50">
        <p class="text-white/60 text-sm mb-4">Join our community</p>
        <div class="flex gap-2">
          <a
            href="https://laracord.com/discord"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-lg bg-[#1a1a1a] hover:bg-[#2a2a2a] flex items-center justify-center transition-colors group"
          >
            <x-icon name="discord" class="w-5 h-5 text-white/60 group-hover:text-primary-500 transition-colors" />
          </a>

          <a
            href="https://twitter.com/laracord"
            target="_blank"
            rel="noopener noreferrer"
            class="w-10 h-10 rounded-lg bg-[#1a1a1a] hover:bg-[#2a2a2a] flex items-center justify-center transition-colors group"
          >
            <x-lucide-twitter class="w-5 h-5 text-white/60 group-hover:text-primary-500 transition-colors" />
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="pt-8">
    <section class="relative min-h-screen flex flex-col items-center justify-center px-4 py-20 overflow-hidden">
      <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(229,57,43,0.15)_0%,rgba(229,57,43,0.08)_40%,transparent_70%)]"
           style="animation: breathe 3s ease-in-out infinite;"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_70%,rgba(229,57,43,0.1)_0%,transparent_50%)]"
           style="animation: float 6s ease-in-out infinite;"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(229,57,43,0.08)_0%,transparent_40%)]"
           style="animation: float-reverse 8s ease-in-out infinite;"></div>

      <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-primary-500/40 rounded-full blur-sm"
           style="animation: drift 12s linear infinite;"></div>
      <div class="absolute top-3/4 right-1/3 w-3 h-3 bg-primary-400/50 rounded-full blur-sm"
           style="animation: drift-reverse 10s linear infinite;"></div>
      <div class="absolute bottom-1/3 left-2/3 w-3 h-3 bg-primary-500/30 rounded-full blur-sm"
           style="animation: drift 14s linear infinite;"></div>
      <div class="absolute top-1/2 right-1/4 w-2 h-2 bg-primary-600/60 rounded-full blur-sm"
           style="animation: drift 16s linear infinite;"></div>
      <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-primary-400/40 rounded-full blur-sm"
           style="animation: drift-reverse 11s linear infinite;"></div>

      <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a]/80 via-transparent to-[#0a0a0a]/40"></div>

      <div class="relative z-10 max-w-6xl mx-auto text-center">
        <div class="mb-8">
          <h1 class="text-6xl md:text-8xl font-bold text-white mb-4 tracking-tight">
            Lara<span class="bg-gradient-to-r from-primary-500 to-primary-400 bg-clip-text text-transparent drop-shadow-[0_0_10px_rgba(229,57,43,0.5)] animate-pulse-glow">cord</span>
          </h1>

          <p class="text-xl md:text-2xl text-white/80 mb-8 max-w-3xl mx-auto leading-relaxed font-medium">
            Create powerful Discord bots with the power of Laravel and DiscordPHP.
          </p>
        </div>

        <div class="mb-12">
          <div class="max-w-4xl w-full mx-auto">
            <div class="bg-[#1a1a1a]/80 backdrop-blur-sm rounded-lg border border-[#333333] overflow-hidden shadow-2xl min-w-full max-w-3xl mx-auto">
              <div class="bg-[#1a1a1a] border-b border-[#333333] px-4 py-3 flex items-center gap-2">
                <div class="flex gap-2">
                  <div class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></div>
                  <div class="w-3 h-3 rounded-full bg-yellow-500 shadow-sm"></div>
                  <div class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></div>
                </div>

                <div class="text-white/80 text-sm ml-4 font-mono">laracord</div>
              </div>

              <div
                class="p-6 font-mono text-sm h-96 overflow-y-auto overflow-x-hidden w-full scrollbar-thin scrollbar-track-[#1a1a1a] scrollbar-thumb-primary-500/60 hover:scrollbar-thumb-primary-500/80 terminal-scroll bg-gradient-to-b from-[#1a1a1a] to-[#1a1a1a]/50 text-left"
                x-data="{
                  // Configuration
                  COMMAND: 'laracord',
                  TYPING_BASE_DELAY: 80,
                  TYPING_RANDOM_VARIANCE: 100,
                  LOG_DELAY_RANGE: [80, 150],
                  COMMAND_PAUSE: 250,

                  // Boot sequence
                  logs: [
                    { level: 'DEBUG', message: 'Initializing DiscordPHP v10.0.0 (DiscordPHP-Http: v10.3.0 & Gateway: v10) on PHP 8.3.24.' },
                    { level: 'DEBUG', message: 'BUCKET getapplications/@me queued REQ GET applications/@me.' },
                    { level: 'DEBUG', message: 'BUCKET getgateway/bot queued REQ GET gateway/bot.' },
                    { level: 'DEBUG', message: 'REQ GET gateway/bot successful.' },
                    { level: 'INFO', message: 'Gateway retrieved and set.' },
                    { level: 'INFO', message: 'Starting connection to websocket.' },
                    { level: 'DEBUG', message: 'REQ GET applications/@me successful.' },
                    { level: 'INFO', message: 'Websocket connection has been created.' },
                    { level: 'INFO', message: 'Received hello.' },
                    { level: 'INFO', message: 'Heartbeat timer initialized.' },
                    { level: 'INFO', message: 'Identifying.' },
                    { level: 'DEBUG', message: 'Ready packet received.' },
                    { level: 'DEBUG', message: 'Resume_gateway_url received.' },
                    { level: 'DEBUG', message: 'Discord trace received.' },
                    { level: 'DEBUG', message: 'Client created and session id stored.' },
                    { level: 'INFO', message: 'Stored guilds.' },
                    { level: 'DEBUG', message: 'Guild available.' },
                    { level: 'INFO', message: 'All guilds are now available.' },
                    { level: 'INFO', message: 'Set up chunking, checking for chunks every 5 seconds.' },
                    { level: 'DEBUG', message: 'Sending 1 chunks with 1 large guilds overall.' },
                    { level: 'DEBUG', message: 'Sending chunk with 1 large guilds.' },
                    { level: 'DEBUG', message: 'Received guild member chunk.' },
                    { level: 'DEBUG', message: 'Parsed 9 members (skipped 0).' },
                    { level: 'DEBUG', message: 'All users have been loaded.' },
                    { level: 'INFO', message: 'Client is ready.' },
                    { level: 'INFO', message: 'Successfully booted Laracord with 2 commands, and 2 interactions.' }
                  ],

                  // State
                  displayedLogs: [],
                  currentIndex: 0,
                  isComplete: false,
                  commandTyped: false,
                  typedCommand: '',

                  // Lifecycle
                  init() {
                    this.startTypingAnimation();
                  },

                  // Command typing animation
                  async startTypingAnimation() {
                    for (let i = 0; i < this.COMMAND.length; i++) {
                      this.typedCommand += this.COMMAND[i];

                      const delay = this.calculateTypingDelay(this.COMMAND[i]);
                      await this.sleep(delay);
                    }

                    this.commandTyped = true;
                    await this.sleep(this.COMMAND_PAUSE);
                    this.startLogAnimation();
                  },

                  // Boot log animation
                  async startLogAnimation() {
                    for (const log of this.logs) {
                      const logWithTime = {
                        ...log,
                        time: this.getCurrentTimestamp()
                      };

                      this.displayedLogs.push(logWithTime);
                      this.scrollToBottom();

                      const delay = this.randomBetween(...this.LOG_DELAY_RANGE);
                      await this.sleep(delay);
                    }

                    this.isComplete = true;
                    this.scrollToBottom();
                  },

                  getCurrentTimestamp() {
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('en-US', {
                      hour12: true,
                      hour: '2-digit',
                      minute: '2-digit',
                      second: '2-digit'
                    });

                    return `[${timeString}]`;
                  },

                  calculateTypingDelay(char) {
                    const baseDelay = this.TYPING_BASE_DELAY;
                    const randomDelay = Math.random() * this.TYPING_RANDOM_VARIANCE + 50;

                    return baseDelay + randomDelay;
                  },

                  randomBetween(min, max) {
                    return Math.random() * (max - min) + min;
                  },

                  sleep(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms));
                  },

                  scrollToBottom() {
                    this.$nextTick(() => {
                      this.$el.scrollTop = this.$el.scrollHeight;
                    });
                  }
                }"
                x-ref="terminal"
              >
                <div class="text-primary-500 mb-1.5 text-left flex items-center gap-1">
                  <span class="text-primary-500">❯</span>
                  <span class="text-white/80 font-mono" x-text="typedCommand"></span>
                  <span x-show="!commandTyped" class="text-white/80 animate-pulse -ml-1">|</span>
                </div>

                <div class="space-y-1 text-left">
                  <template x-for="log in displayedLogs" :key="log.time + log.message">
                    <div class="flex gap-3 text-xs leading-relaxed opacity-90 hover:opacity-100 transition-opacity text-left items-start">
                      <span class="text-white/80 flex-shrink-0" x-text="log.time"></span>
                      <span
                        class="font-medium min-w-[60px] text-center flex-shrink-0"
                        :class="{
                          'bg-blue-600 text-white px-2 py-px rounded text-xs': log.level === 'INFO',
                          'bg-green-600 text-white px-2 py-px rounded text-xs': log.level === 'DEBUG',
                          'text-white/80': log.level !== 'INFO' && log.level !== 'DEBUG'
                        }"
                        x-text="log.level"
                      ></span>
                      <span class="text-white/90 flex-1 break-words min-w-0 overflow-hidden" x-text="log.message"></span>
                    </div>
                  </template>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a
            href="{{ route('docs') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2.5 whitespace-nowrap disabled:pointer-events-none disabled:opacity-50 shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-primary hover:bg-primary/90 h-auto sm:h-11 w-full sm:w-auto bg-gradient-to-r from-primary-500 to-primary-400 hover:from-primary-400 hover:to-primary-500 text-white px-8 sm:px-12 py-4 sm:py-4.5 text-lg sm:text-lg font-semibold rounded-xl shadow-lg hover:shadow-[0_10px_40px_rgba(229,57,43,0.3)] transition-all duration-300 transform hover:scale-105"
          >
            Get Started
            <x-lucide-arrow-right class="w-4.5 h-4.5 sm:w-4.5 sm:h-4.5" />
          </a>

          <a
            href="https://laracord.com/discord"
            class="inline-flex items-center justify-center gap-2.5 whitespace-nowrap disabled:pointer-events-none disabled:opacity-50 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive shadow-xs dark:bg-input/30 dark:border-input dark:hover:bg-input/50 h-auto sm:h-11 w-full sm:w-auto border-2 border-[#666666] text-white/80 hover:bg-[#1a1a1a] hover:text-white hover:border-accent px-8 sm:px-12 py-4 sm:py-4.5 text-lg sm:text-lg font-semibold bg-transparent rounded-xl transition-all duration-300"
          >
            Join the Community
            <x-icon name="discord" class="w-4.5 h-4.5 sm:w-4.5 sm:h-4.5" />
          </a>
        </div>
      </div>
    </section>

    <section id="features" class="py-24 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary-500/10 to-transparent"></div>
      <div class="absolute inset-0 bg-gradient-radial from-primary-500/5 via-transparent to-transparent"></div>

      <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-20">
          <h2 class="text-5xl md:text-6xl font-bold text-white mb-8 tracking-tight">
            Everything You Need to Build <span class="text-primary-500">Amazing Discord Bots</span>
          </h2>

          <p class="text-xl md:text-2xl text-white/80 max-w-4xl mx-auto leading-relaxed font-medium">
            Laracord combines the power of Laravel with Discord's rich API to create an unparalleled development experience for bot creators.
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          @foreach ([
            ['icon' => 'terminal', 'title' => 'Laravel Zero Powered', 'description' => 'Built on Laravel Zero micro-framework with full access to Laravel features like Eloquent, caching, and services.'],
            ['icon' => 'puzzle', 'title' => 'Plugin Ecosystem', 'description' => 'Extensible plugin system allows for reusable components and a growing ecosystem of Discord bot functionality.'],
            ['icon' => 'search', 'title' => 'Auto-Discovery', 'description' => 'Automatic discovery of commands, slash commands, events, and tasks from your app directories with zero configuration.'],
            ['icon' => 'layers', 'title' => 'Command Middleware', 'description' => 'Global and individual command middleware for rate limiting, authentication, and custom logic processing.'],
            ['icon' => 'server', 'title' => 'HTTP Server', 'description' => 'Optional HTTP server with native Laravel routing and Livewire support for web dashboards and webhooks.'],
            ['icon' => 'monitor', 'title' => 'Interactive Console', 'description' => 'Beautiful console with custom prompts, colorful logging, and real-time bot interaction during development.'],
            ['icon' => 'clock', 'title' => 'Background Tasks', 'description' => 'Generate asynchronous services and tasks that run parallel to your bot for scheduled operations.'],
            ['icon' => 'shield-check', 'title' => 'Error Handling', 'description' => 'Laravel-native exception handling with Collision for beautiful error rendering and comprehensive logging.']
          ] as $feature)
            <div class="flex flex-col gap-6 border py-6 shadow-sm bg-[#1a1a1a]/70 backdrop-blur-sm border-[#333333] hover:border-primary-500/60 hover:shadow-[0_0_30px_rgba(229,57,43,0.2)] hover:bg-[#1a1a1a]/90 transition-all duration-500 group rounded-xl overflow-hidden transform hover:scale-[1.02]">
              <div class="p-6">
                <div class="mb-4">
                  @php
                    $iconClass = "lucide-{$feature['icon']}";
                  @endphp
                  <x-dynamic-component :component="$iconClass" class="w-10 h-10 text-primary-500 mb-3 group-hover:scale-125 group-hover:text-primary-500/80 group-hover:drop-shadow-[0_0_8px_rgba(229,57,43,0.6)] transition-all duration-500" />
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-500 transition-colors duration-300">{{ $feature['title'] }}</h3>
                <p class="text-sm text-white/80 leading-relaxed font-medium">{{ $feature['description'] }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <section id="examples" class="py-20 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-[#2a2a2a]/20 to-transparent pointer-events-none"></div>
      <div class="max-w-7xl mx-auto relative">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-primary-400 via-primary-500 to-primary-500/80 bg-clip-text text-transparent mb-6">
            Where Laravel Patterns Power Discord Bots
          </h2>

          <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Use Laravel's expressive syntax and familiar project structure to build Discord bots.
          </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8" x-data="{
          activeTab: 'commands',
          tabs: {
            'commands': 'Commands',
            'slash-commands': 'Slash Commands',
            'listeners': 'Event Listeners',
            'tasks': 'Tasks',
            'middleware': 'Middleware'
          }
        }">
          <div class="lg:w-1/4">
            <div class="space-y-2">
              <template x-for="tab in Object.keys(tabs)" :key="tab">
                <button
                  @click="activeTab = tab"
                  :class="{
                    'bg-primary-500 hover:bg-primary-500/90 text-white shadow-lg shadow-primary-500/25 border border-primary-500/20': activeTab === tab,
                    'text-white/80 hover:text-white hover:bg-[#1a1a1a]/50 border border-transparent hover:border-[#333333]/50 hover:shadow-[0_0_20px_rgba(229,57,43,0.1)]': activeTab !== tab
                  }"
                  class="inline-flex items-center gap-2 whitespace-nowrap rounded-md text-sm font-medium disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] h-9 px-4 py-2 w-full justify-start text-left transition-all duration-300 capitalize"
                  x-text="tabs[tab]"
                >
                </button>
              </template>
            </div>
          </div>

          <div class="lg:w-3/4">
            @foreach ([
              'commands' => [
                'title' => 'Commands',
                'description' => 'Traditional prefix commands with interactive components',
                'filename' => 'PingCommand.php',
                'code' => file_get_contents(resource_path('views/examples/command.php')),
              ],
              'slash-commands' => [
                'title' => 'Slash Commands',
                'description' => 'Auto-syncing slash commands with full Discord API support',
                'filename' => 'HelloSlashCommand.php',
                'code' => file_get_contents(resource_path('views/examples/slash-command.php')),
              ],
              'listeners' => [
                'title' => 'Event Listeners',
                'description' => 'React to Discord events with elegant Laravel event listeners',
                'filename' => 'MessageListener.php',
                'code' => file_get_contents(resource_path('views/examples/listener.php')),
              ],
              'tasks' => [
                'title' => 'Tasks',
                'description' => 'Run timed tasks in the ReactPHP event loop',
                'filename' => 'ReminderTask.php',
                'code' => file_get_contents(resource_path('views/examples/task.php')),
              ],
              'middleware' => [
                'title' => 'Middleware',
                'description' => 'Process commands and interactions with custom middleware',
                'filename' => 'ExampleMiddleware.php',
                'code' => file_get_contents(resource_path('views/examples/middleware.php')),
              ],
            ] as $key => $item)
              <div x-show="activeTab === '{{ $key }}'" class="flex flex-col gap-6 rounded-xl border bg-[#1a1a1a]/90 backdrop-blur-sm border-[#333333]/60 shadow-2xl shadow-[#0a0a0a]/50 overflow-hidden ring-1 ring-white/5 hover:shadow-[0_0_40px_rgba(229,57,43,0.1)] transition-all duration-300">
                <div class="p-0">
                  <div class="p-6 border-b border-[#333333]/60 bg-gradient-to-r from-[#1a1a1a]/80 to-[#1a1a1a]/60 backdrop-blur-sm">
                    <h3 class="text-2xl font-bold text-white mb-2">
                      {{ $item['title'] }}
                    </h3>

                    <p class="text-white/80/90 leading-relaxed">
                      {{ $item['description'] }}
                    </p>
                  </div>

                  <div class="relative">
                    <div class="bg-[#0a0a0a]/90 backdrop-blur-sm px-4 py-3 flex items-center gap-2 border-b border-[#333333]/40">
                      <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500 shadow-sm"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></div>
                      </div>

                      <div class="text-white/80/80 text-sm ml-4">{{ $item['filename'] }}</div>
                    </div>

                    <div class="relative bg-gradient-to-br from-[#0a0a0a]/95 to-[#1a1a1a]/60 backdrop-blur-sm">
                      <div class="p-6 text-sm overflow-x-auto font-mono scrollbar-thin scrollbar-track-[#1a1a1a] scrollbar-thumb-primary-500/60 hover:scrollbar-thumb-primary-500/80 [&_pre]:m-0 [&_pre]:bg-transparent! [&_code]:text-sm [&_code]:leading-relaxed">
                        {!! (new Phiki())->codeToHtml($item['code'], Grammar::Php, Theme::GithubDark) !!}
                      </div>

                      <div class="absolute inset-0 bg-gradient-to-t from-primary-500/3 to-transparent pointer-events-none opacity-60"></div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    {{--
    <section class="py-24 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a] via-[#0a0a0a]/20 to-[#0a0a0a]"></div>
      <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Built with <span class="text-primary-500">Developers</span> in Mind
          </h2>

          <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Join thousands of other developers who are building amazing Discord bots with Laracord.
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          @foreach ([
            ['name' => 'Jamie Parker', 'role' => 'Laravel Developer', 'testimonial' => 'Coming from Laravel web development, Laracord feels like home. Eloquent models for Discord data, familiar artisan commands, and zero learning curve. Built our moderation bot in hours, not days.'],
            ['name' => 'Taylor Kim', 'role' => 'Gaming Community Owner', 'testimonial' => 'Our 15k member server needed custom leveling and economy features. Laracord\'s database integration made complex user tracking trivial. The slash command auto-sync saved us countless deployment headaches.'],
            ['name' => 'Chris Anderson', 'role' => 'DevOps Engineer', 'testimonial' => 'Switched from Discord.js to Laracord for our company bot. The Laravel Zero foundation means proper logging, caching, and queue handling out of the box. Production-ready from day one.']
          ] as $item)
            <div class="bg-[#1a1a1a]/50 backdrop-blur-sm flex flex-col border-[#333333] rounded-xl p-6 hover:border-primary-500/50 hover:shadow-[0_0_30px_rgba(229,57,43,0.15)] hover:scale-[1.02] transition-all duration-300 group">
              <div class="flex items-center mb-4">
                @for ($i = 0; $i < 5; $i++)
                  <x-lucide-star class="w-4 h-4 text-primary-500 fill-current" />
                @endfor
              </div>

              <x-lucide-quote class="w-8 h-8 text-primary-500/50 mb-4" />

              <p class="text-white/80 leading-relaxed mb-6 italic">
                &ldquo;{{ $item['testimonial'] }}&rdquo;
              </p>

              <div class="flex items-center mt-auto">
                <img
                  src="https://i.pravatar.cc/60" alt="{{ $item['name'] }}"
                  class="w-12 h-12 rounded-full border-2 border-primary-500/20"
                />

                <div class="ml-4">
                  <h4 class="font-semibold text-white group-hover:text-primary-500 transition-colors duration-300">
                    {{ $item['name'] }}
                  </h4>

                  <p class="text-sm text-white/80">
                    {{ $item['role'] }}
                  </p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section> --}}

    <section class="py-24 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a] via-[#1a1a1a]/30 to-[#0a0a0a]"></div>
      <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            A Solid Foundation for Your <span class="text-primary-500">Next Discord Bot</span>
          </h2>

          <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Laracord provides a robust and developer-friendly base for crafting sophisticated Discord bots, leveraging proven PHP technologies.
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          @foreach ([
            [
              'icon' => 'terminal',
              'title' => 'Laravel Zero',
              'description' => 'Built on Laravel\'s micro-framework for console applications.',
              'link' => 'https://laravel-zero.com',
            ],
            [
              'icon' => 'server',
              'title' => 'DiscordPHP',
              'description' => 'Powerful PHP library for Discord API integration.',
              'link' => 'https://github.com/discord-php/DiscordPHP',
            ],
            [
              'icon' => 'cpu',
              'title' => 'ReactPHP',
              'description' => 'Asynchronous event-driven programming for real-time bots.',
              'link' => 'https://reactphp.org',
            ],
          ] as $item)
            <a
              href="{{ $item['link'] }}"
              target="_blank"
              rel="noopener noreferrer"
              class="bg-[#1a1a1a]/50 backdrop-blur-sm border-[#333333] hover:border-primary-500/50 hover:shadow-[0_0_30px_rgba(229,57,43,0.15)] hover:scale-[1.02] rounded-xl p-6 transition-all duration-300 group"
            >
              <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-500/20 to-primary-500/10 flex items-center justify-center mb-4 group-hover:from-primary-500/30 group-hover:to-primary-500/20 transition-all duration-300 group-hover:shadow-lg group-hover:shadow-primary-500/25">
                <x-icon name="lucide-{{ $item['icon'] }}" class="w-6 h-6 text-primary-500 group-hover:scale-110 transition-transform duration-300" />
              </div>

              <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary-500 transition-colors duration-300">
                {{ $item['title'] }}
              </h3>

              <p class="text-white/80 leading-relaxed">
                {{ $item['description'] }}
              </p>
            </a>
          @endforeach
        </div>

        <div class="text-center mt-12">
          <p class="text-white/80">
            <span>Want to see what makes Laracord special?</span>
            <a
              href="https://github.com/laracord/framework"
              target="_blank"
              rel="noopener noreferrer"
              class="text-primary-500 hover:text-primary-500/80 transition-colors font-medium"
            >
              View the framework &rarr;
            </a>
          </p>
        </div>
      </div>
    </section>

    <section id="getting-started" class="py-24 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a] via-[#0a0a0a]/30 to-[#0a0a0a]"></div>

      <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Get Started with <span class="text-primary-500">Laracord</span> in Seconds
          </h2>

          <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Download Laracord, configure your Discord token, and boot your bot.
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          @foreach ([
            ['icon' => 'terminal', 'title' => 'Install Laracord', 'description' => 'Get started with a single Composer command.', 'command' => 'composer create-project laracord/laracord my-discord-bot'],
            ['icon' => 'settings', 'title' => 'Configure Your Bot', 'description' => 'Add your Discord bot token to the .env file.', 'command' => 'DISCORD_TOKEN=<token>'],
            ['icon' => 'rocket', 'title' => 'Launch Your Bot', 'description' => 'Launch your bot and begin interacting with Discord in real time.', 'command' => 'php laracord']
          ] as $i => $step)
            <div class="relative group/step" x-data="{ copied: false }">
              <div
                @if ($loop->first)
                  x-clipboard.raw="composer create-project laracord/laracord"
                  x-on:click="
                    $nextTick(() => {
                      copied = true;
                      setTimeout(() => {
                        copied = false;
                      }, 1500);
                    });
                  "
                  class="bg-[#1a1a1a]/50 flex flex-col backdrop-blur-sm border-[#333333] rounded-xl p-8 h-full hover:border-primary-500/50 hover:shadow-[0_0_30px_rgba(229,57,43,0.15)] hover:scale-[1.02] transition-all duration-300 group cursor-pointer"
                @else
                  class="bg-[#1a1a1a]/50 flex flex-col backdrop-blur-sm border-[#333333] rounded-xl p-8 h-full hover:border-primary-500/50 hover:shadow-[0_0_30px_rgba(229,57,43,0.15)] hover:scale-[1.02] transition-all duration-300 group"
                @endif
              >
                @if ($loop->first)
                  <div class="absolute top-4 right-4 opacity-0 group-hover/step:opacity-100 transition-opacity duration-200">
                    <div class="p-1 rounded">
                      <x-lucide-clipboard
                        x-show="!copied"
                        class="w-4 h-4 text-white/50"
                      />

                      <x-lucide-check
                        x-show="copied"
                        class="w-4 h-4 text-green-500"
                      />
                    </div>
                  </div>
                @endif

                <div class="flex items-center mb-6">
                  <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-500 to-primary-500/70 flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 group-hover:scale-110 transition-all duration-300">
                    <x-icon name="lucide-{{ $step['icon'] }}" class="w-6 h-6 text-white" />
                  </div>

                  <div class="ml-4">
                    <div class="text-sm font-medium text-primary-500">Step {{ $i + 1 }}</div>

                    <h3 class="text-xl font-bold text-white group-hover:text-primary-500 transition-colors duration-300">
                      {{ $step['title'] }}
                    </h3>
                  </div>
                </div>

                <p class="text-white/80 mb-6 leading-relaxed">
                  {{ $step['description'] }}
                </p>

                <div class="mt-auto bg-[#0a0a0a]/50 backdrop-blur-sm rounded-lg p-4 border border-[#333333] group-hover:border-primary-500/30 transition-colors duration-300 h-16 flex items-center">
                  <code class="text-primary-500 font-mono text-sm break-all">{{ $step['command'] }}</code>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="text-center mt-12">
          <a
            href="{{ route('docs') }}"
            wire:navigate
            class="bg-gradient-to-r from-primary-500 to-primary-500/80 text-white px-8 py-4 rounded-lg font-semibold hover:from-primary-500/90 hover:to-primary-500/70 hover:shadow-[0_0_25px_rgba(229,57,43,0.4)] hover:scale-105 transition-all duration-300 group inline-flex items-center mx-auto"
          >
            <span>Start Building Now</span>
            <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
          </a>
        </div>
      </div>
    </section>

    <section id="faq" class="py-24 px-4 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a] via-[#1a1a1a]/20 to-[#0a0a0a]"></div>
      <div class="max-w-4xl mx-auto relative z-10">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Frequently Asked Questions About <span class="text-primary-500">Laracord</span>
          </h2>

          <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
            Everything you need to know about building Discord bots with Laravel and Laracord.
          </p>
        </div>

        <div class="space-y-4" x-data="{ openFaq: null }">
          @foreach ([
            [
                'question' => 'What is Laracord?',
                'answer' => 'Laracord is a micro-framework that provides a powerful starting point for building Discord bots. It leverages the elegance of Laravel and the DiscordPHP library to enable developers to create functional, elegant bots with features like databases, caching, and more.'
            ],
            [
                'question' => 'How does Laracord work with Laravel?',
                'answer' => 'Laracord is built on Laravel Zero, a lightweight micro-framework for console applications. It incorporates familiar Laravel patterns such as Eloquent ORM, service providers, dependency injection, and Artisan-like commands (accessed via `php laracord`), making it accessible for Laravel developers while focusing on Discord bot development.'
            ],
            [
                'question' => 'Can I use Laracord in an existing Laravel project?',
                'answer' => 'No, Laracord is designed as a standalone starting point using Laravel Zero for console-based applications like Discord bots. It is installed via `composer create-project`, creating a new project structure. It is not intended as a package to integrate directly into an existing Laravel web application. For integration needs, consider connecting via shared databases or APIs instead.'
            ],
            [
                'question' => 'Do I need to know Discord\'s API?',
                'answer' => 'Not necessarily! Laracord abstracts much of the Discord API complexity through DiscordPHP, allowing you to build bots using Laravel-style syntax. Basic understanding of Discord concepts like intents, commands, and events is helpful but not required to get started.'
            ],
            [
                'question' => 'What databases does Laracord support?',
                'answer' => 'Laracord supports all databases compatible with Laravel, including MySQL, PostgreSQL, and SQLite. You can use Eloquent models to manage Discord-related data, such as user preferences or server settings, leveraging Laravel\'s out-of-the-box database and caching features via Laravel Zero.'
            ],
            [
                'question' => 'Can I use Laracord for web interfaces?',
                'answer' => 'Yes! Laracord includes an optional HTTP server powered by ReactPHP, which supports Laravel routing for building APIs or webhooks. You can also integrate Laravel Livewire (installed separately via Composer) for real-time web interfaces, such as admin panels or dashboards that interact with your bot\'s data. However, the HTTP server is recommended for personal or internal use rather than public user-facing applications.'
            ],
          ] as $index => $item)
            <div
              class="bg-[#1a1a1a]/50 backdrop-blur-sm border border-[#333333] rounded-xl overflow-hidden transition-all duration-300 hover:border-primary-500/50 hover:shadow-[0_0_30px_rgba(229,57,43,0.15)] hover:bg-[#1a1a1a]/70 group"
              :class="{ 'border-primary-500/50 shadow-[0_0_30px_rgba(229,57,43,0.15)]': openFaq === {{ $index }} }"
            >
              <button
                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-[#2a2a2a]/30 transition-colors"
                @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
              >
                <span
                  class="text-lg font-semibold transition-colors duration-300"
                  :class="openFaq === {{ $index }} ? 'text-primary-500' : 'text-white group-hover:text-primary-500'"
                >
                  {{ $item['question'] }}
                </span>

                <span
                  class="transition-all duration-300"
                  :class="openFaq === {{ $index }} ? 'rotate-180 text-primary-500' : 'text-white/80 group-hover:text-primary-500'"
                >
                  <x-lucide-chevron-down class="w-5 h-5" />
                </span>
              </button>

              <div
                x-show="openFaq === {{ $index }}"
                x-collapse
                class="px-6 py-4"
              >
                <div class="text-white/80 leading-relaxed">
                  {{ $item['answer'] }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="py-24 px-4 bg-[#111111]/50">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
          Ready to Build Something <span class="text-primary-500">Amazing?</span>
        </h2>

        <p class="text-xl text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
          Join a growing community of developers building modern Discord bots powered by Laracord.
        </p>

        <div class="flex flex-col sm:flex-row gap-6 justify-center">
          <a
            wire:navigate
            href="{{ route('docs') }}"
            class="inline-flex items-center justify-center gap-2 text-lg font-semibold bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-lg transition-colors"
          >
            Get Started Now
            <x-lucide-arrow-right class="w-5 h-5" />
          </a>

          <a
            href="https://github.com/laracord/laracord"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center justify-center gap-2 text-lg font-semibold border border-white/20 text-white/90 hover:bg-white/5 px-8 py-4 rounded-lg transition-colors"
          >
            View on GitHub
            <x-lucide-github class="w-5 h-5" />
          </a>
        </div>
      </div>
    </section>

    <x-footer />
  </div>
</main>
