@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $article = SiteContent::article($slug);

    if (! $article) {
        abort(404);
    }

    $siteName = config('app.name', 'Laravel');
    $author = $article['author_info'];
    $authorUrl = isset(SiteContent::data()['authors'][$author['key']]) ? route('author', $author['key']) : route('home');
    $rendered = \App\Support\ArticleMarkdown::render($article['body']);
    $publishedAt = \Carbon\Carbon::parse($article['date']);

    $relatedArticles = SiteContent::articles($article['section'])
        ->where('slug', '!=', $article['slug'])
        ->take(3)
        ->values();

    $title = $article['title'];
    $description = Str::limit($article['excerpt'], 155);
    $shareArticle = $article;
@endphp

@section('content')
    <article>
        {{-- Article header --}}
        <header class="mx-auto max-w-4xl px-4 pt-8 sm:px-6 lg:px-8">
            <nav class="flex flex-wrap items-center gap-2 text-xs text-muted" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-ink">{{ __('Home') }}</a>
                <span class="text-zinc-300">/</span>
                <a href="{{ route('section', $article['section']) }}" wire:navigate class="hover:text-ink">{{ $article['section_title'] }}</a>
            </nav>

            <a href="{{ route('section', $article['section']) }}" wire:navigate class="tag mt-12">{{ $article['section_title'] }}</a>

            <h1 class="display mt-5 text-4xl leading-[1.06] text-balance sm:text-6xl">
                {{ $article['title'] }}
            </h1>

            <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 border-y border-line py-4 text-sm text-muted">
                <a href="{{ $authorUrl }}" wire:navigate class="flex items-center gap-3">
                    @include('partials.avatar', ['author' => $author, 'class' => 'size-10 text-xs'])
                    <span>
                        <span class="block font-medium text-ink hover:text-brand-700">{{ $author['name'] }}</span>
                        <span class="text-xs">{{ $author['role'] }}</span>
                    </span>
                </a>
                <span class="hidden h-6 w-px bg-line sm:block"></span>
                <time datetime="{{ $article['date'] }}">{{ $publishedAt->translatedFormat(__('F j, Y')) }}</time>
                <span class="text-zinc-300">/</span>
                <span>{{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}</span>
            </div>
        </header>

        @if ($article['image'])
            <div class="mx-auto mt-10 max-w-6xl px-4 sm:px-6 lg:px-8">
                <img src="{{ asset('images/'.$article['image']) }}" alt="{{ $article['title'] }}" class="aspect-[16/9] w-full object-cover sm:aspect-[2/1]" />
            </div>
        @endif

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($article['locale'] !== app()->getLocale())
                <p class="mx-auto mt-10 flex max-w-3xl items-start gap-3 rounded-2xl bg-brand-50 p-5 text-sm leading-relaxed text-body">
                    <flux:icon name="language" variant="mini" class="mt-0.5 size-5 shrink-0 text-brand-600" />
                    {{ __('This article is currently available in English only.') }}
                </p>
            @endif

            <div class="grid gap-12 pt-12 pb-16 lg:grid-cols-12">
                {{-- Table of contents --}}
                @if (count($rendered['toc']) > 1)
                    <aside class="lg:col-span-4 lg:order-2">
                        <nav class="border-t border-ink pt-5 lg:sticky lg:top-28" aria-label="{{ __('In this article') }}" x-data="{ open: false }">
                            <button type="button" class="flex w-full items-center justify-between text-left lg:pointer-events-none" @click="open = ! open">
                                <span class="text-[11px] font-semibold tracking-[0.16em] text-ink uppercase">{{ __('In this article') }}</span>
                                <flux:icon name="chevron-down" variant="mini" class="size-4 text-muted transition lg:hidden" ::class="open && 'rotate-180'" />
                            </button>
                            <ol class="mt-3 hidden max-h-[60vh] space-y-0.5 overflow-y-auto text-sm lg:block" :class="open && '!block'">
                                @foreach ($rendered['toc'] as $item)
                                    <li>
                                        <a href="#{{ $item['id'] }}" @click="open = false" class="block border-l border-line py-1.5 pl-4 leading-snug text-muted transition hover:border-brand-600 hover:text-ink">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </aside>
                @endif

                <div class="min-w-0 lg:col-span-8 lg:order-1">
                    @include('partials.article-body', ['html' => $rendered['html']])

                    {{-- Author card --}}
                    <div class="mt-16 flex flex-col gap-5 border-t border-ink pt-8 sm:flex-row sm:items-start">
                        @include('partials.avatar', ['author' => $author, 'class' => 'size-16 text-lg'])
                        <div>
                            <p class="text-xs font-medium text-muted">{{ __('Written by') }}</p>
                            <p class="mt-1 font-serif text-2xl text-ink">{{ $author['name'] }}</p>
                            <p class="text-sm text-muted">{{ $author['role'] }}</p>
                            @if ($author['bio'])
                                <p class="mt-3 text-sm leading-relaxed text-body">{{ $author['bio'] }}</p>
                            @endif
                            <a href="{{ $authorUrl }}" wire:navigate class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-ink link-underline">
                                {{ __('Read full bio') }}
                                <flux:icon name="arrow-right" variant="micro" class="size-4" />
                            </a>
                        </div>
                    </div>

                    <p class="mt-8 flex gap-3 bg-soft p-5 text-sm leading-relaxed text-muted">
                        <flux:icon name="information-circle" variant="mini" class="size-5 shrink-0 text-ink" />
                        <span>
                            <span class="font-medium text-body">{{ __('Educational content only.') }}</span>
                            {{ __('This article is for general information and is not personalized medical, financial, or professional advice.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </article>

    {{-- Related articles --}}
    @if ($relatedArticles->isNotEmpty())
        <section>
            <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-4 border-b border-ink pb-4 sm:flex-row sm:items-end">
                    <h2 class="display text-3xl">{{ __('More in :section', ['section' => $article['section_title']]) }}</h2>
                    <a href="{{ route('section', $article['section']) }}" wire:navigate class="text-sm font-medium text-ink link-underline">
                        {{ __('Show more') }}
                    </a>
                </div>
                <div class="mt-10 grid gap-x-10 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedArticles as $related)
                        @include('partials.article-card', ['article' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
