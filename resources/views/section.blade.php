@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $sectionMeta = SiteContent::section($section);

    if (! $sectionMeta) {
        abort(404);
    }

    $siteName = config('app.name', 'Laravel');
    $sectionArticles = SiteContent::articles($section);

    $perPage = 12;
    $totalArticles = $sectionArticles->count();
    $lastPage = max(1, (int) ceil($totalArticles / $perPage));
    $page = max(1, min((int) (request()->route('page') ?? request()->query('page', 1)), $lastPage));
    $pagedArticles = $sectionArticles->forPage($page, $perPage)->values();

    $pageLink = fn ($p) => $p > 1
        ? route('section.page', ['section' => $section, 'page' => $p])
        : route('section', $section);

    $otherCategories = SiteContent::categories()->where('id', '!=', $section);

    $sectionPrograms = SiteContent::programs()->where('section', $section)->values();

    $title = $sectionMeta['title'];
    $description = $sectionMeta['description'] ?? __(':section articles from :site.', ['section' => $sectionMeta['title'], 'site' => $siteName]);
@endphp

@section('content')
    @include('partials.page-hero', [
        'crumbs' => [__('Articles') => route('articles'), $sectionMeta['title'] => null],
        'eyebrow' => __('Category'),
        'heading' => $sectionMeta['title'],
        'lead' => $sectionMeta['description'],
        'meta' => trans_choice(':count article|:count articles', $totalArticles),
        'icon' => $sectionMeta['icon'],
    ])

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($sectionPrograms->isNotEmpty() && $page === 1)
            <div class="mb-16">
                <span class="eyebrow">{{ __('Main guides') }}</span>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($sectionPrograms as $program)
                        @include('partials.program-card', ['program' => $program])
                    @endforeach
                </div>
            </div>
        @endif

        @if ($pagedArticles->isNotEmpty())
            <div class="grid gap-x-10 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($pagedArticles as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>

            @include('partials.pagination')
        @else
            @include('partials.empty-state')
        @endif
    </section>

    {{-- Other topics --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8">
        <div class="border-b border-ink pb-4">
            <h2 class="display text-3xl">{{ __('Keep exploring') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-x-10">
            @foreach ($otherCategories as $category)
                <a href="{{ route('section', $category['id']) }}" wire:navigate class="group flex items-center justify-between gap-4 border-b border-line py-5">
                    <span class="font-serif text-2xl text-ink transition group-hover:text-brand-700">{{ $category['title'] }}</span>
                    <span class="flex items-center gap-3 text-xs text-muted tabular-nums">
                        {{ $category['count'] }}
                        <flux:icon name="arrow-up-right" variant="micro" class="size-4 transition group-hover:text-brand-600" />
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endsection
