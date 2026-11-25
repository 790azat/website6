{{--
    Article card. Expects $article (from SiteContent) and optional
    $variant: 'grid' (default), 'featured' (image beside the text),
    'compact' (small row for sidebars / related lists) or 'list' (text-only row).
--}}
@php
    $variant = $variant ?? 'grid';
    $date = \Carbon\Carbon::parse($article['date'])->translatedFormat(__('M j, Y'));
@endphp

@if ($variant === 'featured')
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group grid gap-8 md:grid-cols-12 md:gap-10">
        <div class="relative flex aspect-[3/2] items-center justify-center overflow-hidden md:col-span-7">
            @include('partials.article-art', ['iconClass' => 'size-16'])
        </div>
        <div class="flex flex-col justify-center md:col-span-5">
            <span class="tag">{{ $article['section_title'] }}</span>
            <h3 class="display mt-4 text-3xl leading-[1.12] text-balance transition group-hover:text-brand-700 sm:text-[2.5rem]">{{ $article['title'] }}</h3>
            <p class="mt-5 line-clamp-3 leading-relaxed text-muted">{{ $article['excerpt'] }}</p>
            <p class="mt-6 text-xs text-muted">{{ $date }} &middot; {{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}</p>
        </div>
    </a>
@elseif ($variant === 'compact')
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group flex min-w-0 items-start gap-4">
        <div class="relative flex size-20 shrink-0 items-center justify-center overflow-hidden">
            @include('partials.article-art', ['iconClass' => 'size-7'])
        </div>
        <div class="min-w-0">
            <p class="tag text-[10px]">{{ $article['section_title'] }}</p>
            <p class="mt-1.5 line-clamp-2 font-serif text-lg leading-snug text-ink group-hover:text-brand-700">{{ $article['title'] }}</p>
        </div>
    </a>
@elseif ($variant === 'list')
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group flex gap-5 border-t border-line py-5">
        @isset($number)
            <span class="w-8 shrink-0 font-serif text-2xl leading-none text-brand-600 tabular-nums">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</span>
        @endisset
        <span class="min-w-0">
            <span class="block text-[10px] font-semibold tracking-[0.16em] text-muted uppercase">{{ $article['section_title'] }}</span>
            <span class="mt-1.5 block font-serif text-xl leading-snug text-ink transition group-hover:text-brand-700">{{ $article['title'] }}</span>
        </span>
    </a>
@else
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group flex flex-col">
        <div class="relative flex aspect-[3/2] items-center justify-center overflow-hidden">
            @include('partials.article-art')
        </div>
        <div class="flex flex-1 flex-col pt-5">
            <span class="tag">{{ $article['section_title'] }}</span>
            <h3 class="mt-2.5 line-clamp-3 font-serif text-[1.35rem] leading-[1.25] text-ink transition group-hover:text-brand-700">
                {{ $article['title'] }}
            </h3>
            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">{{ $article['excerpt'] }}</p>
            <p class="mt-auto pt-4 text-xs text-muted">
                <time datetime="{{ $article['date'] }}">{{ $date }}</time>
                &middot; {{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}
            </p>
        </div>
    </a>
@endif
