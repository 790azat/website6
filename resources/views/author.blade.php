@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    if (! isset(SiteContent::data()['authors'][$slug])) {
        abort(404);
    }

    $author = SiteContent::author($slug);
    $articles = SiteContent::articles()->where('author', $slug)->values();

    $title = $author['name'];
    $description = Str::limit((string) $author['bio'], 155);
@endphp

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => $author['role'],
        'heading' => $author['name'],
        'lead' => $author['bio'],
        'crumbs' => [$author['name'] => null],
        'meta' => $author['count'] ? trans_choice(':count article|:count articles', $author['count']) : null,
    ])

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12">
            <aside class="lg:col-span-4">
                <div class="rounded-3xl border border-line bg-white p-7 lg:sticky lg:top-24">
                    @include('partials.avatar', ['author' => $author, 'class' => 'size-20 text-xl'])
                    <p class="mt-5 text-lg font-semibold text-ink">{{ $author['name'] }}</p>
                    <p class="text-sm text-brand-600">{{ $author['role'] }}</p>
                    <dl class="mt-6 divide-y divide-line border-t border-line text-sm">
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-muted">{{ __('Articles') }}</dt>
                            <dd class="font-medium text-ink">{{ $author['count'] }}</dd>
                        </div>
                    </dl>
                </div>
            </aside>

            <div class="lg:col-span-8">
                <h2 class="text-sm font-semibold text-muted">{{ __('About the author') }}</h2>
                <p class="mt-4 text-lg leading-[1.85] text-body">{{ $author['bio_long'] }}</p>

                <p class="mt-10 flex gap-3 rounded-2xl bg-soft p-5 text-sm leading-relaxed text-muted">
                    <flux:icon name="information-circle" variant="mini" class="size-5 shrink-0 text-brand-500" />
                    <span>{{ __('Our articles are for general information and are not personalized medical, financial, or professional advice.') }}</span>
                </p>
            </div>
        </div>
    </section>

    <section class="border-t border-line">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold tracking-tight text-ink">{{ __('Latest from :name', ['name' => $author['name']]) }}</h2>
            @if ($articles->isNotEmpty())
                <div class="mt-8 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($articles as $article)
                        @include('partials.article-card', ['article' => $article])
                    @endforeach
                </div>
            @else
                @include('partials.empty-state', [
                    'heading' => __('Articles are on the way'),
                    'text' => __(':name is preparing the first guides. Check back soon.', ['name' => $author['name']]),
                ])
            @endif
        </div>
    </section>
@endsection
