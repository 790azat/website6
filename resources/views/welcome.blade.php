@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $siteName = config('app.name', 'Laravel');
    $title = null;
    $description = __(':site publishes plain-spoken, well-researched guides to the everyday decisions that shape a life.', ['site' => $siteName]);

    $categories = SiteContent::categories();
    $allArticles = SiteContent::articles();

    // Front page: one lead story and two side stories, newest first, each from a different topic where possible.
    $front = collect();
    foreach ($allArticles as $article) {
        if ($front->count() === 3) {
            break;
        }
        if (! $front->pluck('section')->contains($article['section'])) {
            $front->push($article);
        }
    }
    $lead = $front->first();
    $side = $front->slice(1)->values();
    $used = $front->pluck('slug');

    // Numbered reading list: the next eight, interleaved across topics.
    $perTopic = $categories->map(fn ($category) => SiteContent::articles($category['id'])->whereNotIn('slug', $used)->values());
    $reading = collect();
    foreach ([0, 1] as $n) {
        foreach ($perTopic as $list) {
            if ($list->has($n)) {
                $reading->push($list->get($n));
            }
        }
    }
    $reading = $reading->take(8);
    $used = $used->merge($reading->pluck('slug'));

    $remaining = $allArticles->whereNotIn('slug', $used)->values();
    $featured = $remaining->first();
    $latest = $remaining->slice(1, 6)->values();
@endphp

@section('content')
    {{-- Masthead --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 border-b border-ink pt-12 pb-10 lg:flex-row lg:items-end lg:justify-between lg:pt-16">
            <h1 class="display max-w-4xl text-5xl leading-[1.02] text-balance sm:text-6xl lg:text-[5.25rem]">
                {{ __('Clear notes on') }} <em class="text-brand-600">{{ __('everyday') }}</em> {{ __('decisions.') }}
            </h1>
            <div class="max-w-xs shrink-0 text-sm leading-relaxed text-muted lg:pb-3">
                <p>{{ __('Practical, carefully researched guides. No hype, no clutter, just what you need to decide well.') }}</p>
                <p class="mt-4 text-xs font-semibold tracking-[0.16em] text-ink uppercase">
                    {{ trans_choice(':count article|:count articles', $allArticles->count()) }} &middot; {{ trans_choice(':count topic|:count topics', $categories->count()) }}
                </p>
            </div>
        </div>
    </section>

    {{-- Front page --}}
    @if ($lead)
        <section class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12">
                <a href="{{ route('article', $lead['slug']) }}" wire:navigate class="group lg:col-span-8 lg:border-r lg:border-line lg:pr-10">
                    <div class="relative flex aspect-[16/10] items-center justify-center overflow-hidden">
                        @include('partials.article-art', ['article' => $lead, 'iconClass' => 'size-20'])
                    </div>
                    <span class="tag mt-6">{{ $lead['section_title'] }}</span>
                    <h2 class="display mt-3 text-3xl leading-[1.1] text-balance transition group-hover:text-brand-700 sm:text-[2.75rem]">{{ $lead['title'] }}</h2>
                    <p class="mt-4 line-clamp-3 max-w-2xl text-lg leading-relaxed text-muted">{{ $lead['excerpt'] }}</p>
                    <p class="mt-5 text-xs text-muted">{{ __(':minutes min read', ['minutes' => $lead['reading_minutes']]) }}</p>
                </a>

                <div class="flex flex-col gap-10 lg:col-span-4">
                    @foreach ($side as $article)
                        <div @class(['border-t border-line pt-10' => ! $loop->first])>
                            @include('partials.article-card', ['article' => $article])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('partials.empty-state')
        </section>
    @endif

    {{-- Reading list + topic index --}}
    @if ($reading->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 pt-24 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="flex items-end justify-between border-b border-ink pb-4">
                        <h2 class="display text-3xl">{{ __('The reading list') }}</h2>
                        <a href="{{ route('articles') }}" wire:navigate class="text-sm font-medium text-ink link-underline">{{ __('Show more') }}</a>
                    </div>
                    <div class="grid sm:grid-cols-2 sm:gap-x-10">
                        @foreach ($reading as $article)
                            @include('partials.article-card', ['article' => $article, 'variant' => 'list', 'number' => $loop->iteration])
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="border-b border-ink pb-4">
                        <h2 class="display text-3xl">{{ __('Topics') }}</h2>
                    </div>
                    <ul>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('section', $category['id']) }}" wire:navigate class="group flex items-center gap-5 border-b border-line py-5">
                                    <span class="w-6 font-serif text-sm text-muted tabular-nums">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-serif text-2xl leading-tight text-ink transition group-hover:text-brand-700">{{ $category['title'] }}</span>
                                        @if ($category['description'])
                                            <span class="mt-1 line-clamp-1 block text-sm text-muted">{{ $category['description'] }}</span>
                                        @endif
                                    </span>
                                    <span class="text-xs text-muted tabular-nums">{{ $category['count'] }}</span>
                                    <flux:icon name="arrow-up-right" variant="micro" class="size-4 text-muted transition group-hover:text-brand-600" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured --}}
    @if ($featured)
        <section class="mt-24 border-y border-line bg-soft">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <span class="eyebrow">{{ __('Editor’s Pick') }}</span>
                <div class="mt-8">
                    @include('partials.article-card', ['article' => $featured, 'variant' => 'featured'])
                </div>
            </div>
        </section>
    @endif

    {{-- Latest --}}
    @if ($latest->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 pt-24 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between border-b border-ink pb-4">
                <h2 class="display text-3xl">{{ __('Latest Articles') }}</h2>
                <a href="{{ route('articles') }}" wire:navigate class="text-sm font-medium text-ink link-underline">{{ __('Show more') }}</a>
            </div>
            <div class="mt-10 grid gap-x-10 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latest as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>
        </section>
    @endif
@endsection
