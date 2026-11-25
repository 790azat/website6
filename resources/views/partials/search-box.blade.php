{{--
    Article search: filters an inline index of this locale's articles as you type.
    Results are real links rendered here (not built in JS) so the static export
    rewrites them to the right path and language like every other link.
    Options: $id (input id, required to be unique per page), $size ('sm' | 'lg').
--}}
@php
    $searchArticles = \App\Support\SiteContent::articles();
    $searchIndex = $searchArticles->map(fn ($article) => mb_strtolower($article['title'].' '.$article['section_title'].' '.$article['excerpt']))->values();
    $large = ($size ?? 'sm') === 'lg';
@endphp
<div
    x-data="{
        query: '',
        open: false,
        texts: @js($searchIndex),
        get results() {
            const words = this.query.toLowerCase().split(/\s+/).filter(Boolean);
            if (! words.length) return [];
            const found = [];
            for (let i = 0; i < this.texts.length && found.length < 6; i++) {
                if (words.every(word => this.texts[i].includes(word))) found.push(i);
            }
            return found;
        },
    }"
    @click.outside="open = false"
    @keydown.escape="open = false"
    class="relative w-full"
>
    <form role="search" @submit.prevent="if (results.length) $refs['result' + results[0]].click()">
        <label for="{{ $id }}" class="sr-only">{{ __('Search articles') }}</label>
        <div class="relative">
            <flux:icon name="magnifying-glass" variant="mini" @class(['pointer-events-none absolute top-1/2 -translate-y-1/2 text-muted', 'left-0 size-4' => ! $large, 'left-0 size-6 text-ink' => $large]) />
            <input
                id="{{ $id }}"
                type="search"
                autocomplete="off"
                x-model="query"
                @focus="open = true"
                @input="open = true"
                placeholder="{{ __('Search articles...') }}"
                @class([
                    'w-full border-0 border-b border-line bg-transparent text-ink placeholder:text-muted transition focus:border-ink focus:ring-0 focus:outline-none',
                    'py-2.5 pr-2 pl-7 text-sm' => ! $large,
                    'border-ink py-3 pr-2 pl-10 font-serif text-2xl' => $large,
                ])
            />
        </div>
    </form>

    <div
        x-cloak
        x-show="open && query.trim() !== ''"
        x-transition.opacity
        class="absolute inset-x-0 top-full z-50 mt-2 flex max-h-[70vh] flex-col overflow-y-auto border border-line bg-white shadow-lg shadow-ink/5"
    >
        @foreach ($searchArticles as $i => $article)
            <a
                href="{{ route('article', $article['slug']) }}"
                x-ref="result{{ $i }}"
                :style="{ order: results.indexOf({{ $i }}) }"
                class="hidden border-b border-line px-5 py-3 last:border-0 hover:bg-soft focus:bg-soft focus:outline-none"
                :class="{ 'hidden': ! results.includes({{ $i }}), 'block': results.includes({{ $i }}) }"
            >
                <span class="block text-[10px] font-semibold tracking-[0.14em] text-brand-600 uppercase">{{ $article['section_title'] }}</span>
                <span class="mt-1 block font-serif text-lg leading-snug text-ink">{{ $article['title'] }}</span>
            </a>
        @endforeach
        <p x-show="results.length === 0" class="px-5 py-4 text-sm text-muted">{{ __('No articles found.') }}</p>
    </div>
</div>
