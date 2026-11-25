{{--
    Header band for inner pages.
    Expects $heading; optional $eyebrow, $lead, $crumbs ([label => url|null]),
    $icon (unused in this design, kept for compatibility) and $meta (small text line).
--}}
<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    @if (! empty($crumbs))
        <nav class="flex flex-wrap items-center gap-2 pt-8 text-xs text-muted" aria-label="{{ __('Breadcrumb') }}">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-ink">{{ __('Home') }}</a>
            @foreach ($crumbs as $label => $url)
                <span class="text-zinc-300">/</span>
                @if ($url)
                    <a href="{{ $url }}" wire:navigate class="hover:text-ink">{{ $label }}</a>
                @else
                    <span class="min-w-0 truncate text-body">{{ $label }}</span>
                @endif
            @endforeach
        </nav>
    @endif

    <div class="grid gap-6 border-b border-ink pt-12 pb-10 lg:grid-cols-12 lg:items-end lg:pt-16">
        <div class="lg:col-span-8">
            @if (! empty($eyebrow))
                <span class="eyebrow">{{ $eyebrow }}</span>
            @endif
            <h1 class="display mt-4 text-5xl leading-[1.02] text-balance sm:text-6xl lg:text-7xl">
                {{ $heading }}
            </h1>
        </div>
        <div class="lg:col-span-4">
            @if (! empty($lead))
                <p class="leading-relaxed text-pretty text-muted">{{ $lead }}</p>
            @endif
            @if (! empty($meta))
                <p class="mt-4 text-xs font-semibold tracking-[0.16em] text-ink uppercase">{{ $meta }}</p>
            @endif
        </div>
    </div>
</section>
