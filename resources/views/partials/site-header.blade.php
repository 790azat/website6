{{--
    Shared site header: a thin date line, then the logo with the category
    links set as plain text, a search toggle and the menu button on mobile.
    Expects $categories (from layouts.site) and x-data="{ mobileOpen: false }" on <body>.
--}}
<header x-data="{ searchOpen: false }" class="sticky top-0 z-40 border-b border-line bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-[4.5rem] max-w-7xl items-center gap-8 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" wire:navigate class="shrink-0" aria-label="{{ __(':site home', ['site' => config('app.name')]) }}">
            @include('partials.logo')
        </a>

        <nav class="hidden flex-1 items-center gap-7 text-[13px] font-medium text-body lg:flex" aria-label="{{ __('Categories') }}">
            @foreach ($categories as $category)
                <a
                    href="{{ route('section', $category['id']) }}"
                    wire:navigate
                    @class([
                        'relative py-1 transition hover:text-ink',
                        'text-ink after:absolute after:inset-x-0 after:-bottom-[1.45rem] after:h-0.5 after:bg-brand-600' => request()->route('section') === $category['id'],
                    ])
                >{{ $category['title'] }}</a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-2">
            <button
                type="button"
                @click="searchOpen = ! searchOpen; $nextTick(() => searchOpen && document.getElementById('header-search')?.focus())"
                :aria-expanded="searchOpen"
                class="flex size-10 items-center justify-center text-ink transition hover:text-brand-600"
                aria-label="{{ __('Search articles') }}"
            >
                <flux:icon name="magnifying-glass" class="size-5" />
            </button>

            <a href="{{ route('articles') }}" wire:navigate class="hidden border border-ink px-4 py-2 text-[13px] font-medium text-ink transition hover:bg-ink hover:text-white sm:inline-flex">
                {{ __('All Articles') }}
            </a>

            <button
                type="button"
                @click="mobileOpen = true"
                class="flex size-10 items-center justify-center text-ink lg:hidden"
                aria-label="{{ __('Open menu') }}"
            >
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path d="M4 8h16M4 16h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Search drawer --}}
    <div x-cloak x-show="searchOpen" x-transition.opacity.duration.150ms @keydown.escape.window="searchOpen = false" class="border-t border-line bg-white">
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6">
            @include('partials.search-box', ['id' => 'header-search', 'size' => 'lg'])
        </div>
    </div>
</header>

{{-- Mobile menu --}}
<div x-show="mobileOpen" x-cloak class="fixed inset-0 z-50 lg:hidden" @keydown.escape.window="mobileOpen = false">
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-ink/20" @click="mobileOpen = false"></div>
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 flex w-full max-w-sm flex-col bg-white"
    >
        <div class="flex h-[4.5rem] items-center justify-between border-b border-line px-5">
            <a href="{{ route('home') }}" wire:navigate @click="mobileOpen = false">
                @include('partials.logo', ['size' => 'sm'])
            </a>
            <button type="button" @click="mobileOpen = false" class="flex size-10 items-center justify-center text-ink" aria-label="{{ __('Close menu') }}">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <div class="px-5 pt-6">
            @include('partials.search-box', ['id' => 'mobile-search'])
        </div>

        <nav class="flex flex-1 flex-col overflow-y-auto px-5 py-6">
            <p class="eyebrow mb-2">{{ __('Categories') }}</p>
            @foreach ($categories as $category)
                <a href="{{ route('section', $category['id']) }}" wire:navigate @click="mobileOpen = false" class="flex items-baseline justify-between border-b border-line py-3.5">
                    <span class="font-serif text-xl text-ink">{{ $category['title'] }}</span>
                    <span class="text-xs text-muted tabular-nums">{{ $category['count'] }}</span>
                </a>
            @endforeach

            <a href="{{ route('articles') }}" wire:navigate @click="mobileOpen = false" class="btn-primary mt-8">{{ __('All Articles') }}</a>

            <div class="mt-auto flex gap-6 pt-8 text-sm text-muted">
                <a href="{{ route('terms-of-use') }}" wire:navigate @click="mobileOpen = false" class="hover:text-ink">{{ __('Terms') }}</a>
                <a href="{{ route('privacy-policy') }}" wire:navigate @click="mobileOpen = false" class="hover:text-ink">{{ __('Privacy policy') }}</a>
            </div>
        </nav>
    </div>
</div>
