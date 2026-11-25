{{--
    Shown where an article list has nothing to display yet.
--}}
<div class="mt-12 flex flex-col items-center rounded-3xl border border-dashed border-line bg-soft px-6 py-16 text-center">
    <span class="flex size-16 items-center justify-center rounded-full bg-brand-50 text-brand-600">
        <flux:icon name="pencil-square" class="size-8" />
    </span>
    <h3 class="mt-6 text-2xl font-semibold text-ink">{{ $heading ?? __('New articles are on the way') }}</h3>
    <p class="mt-3 max-w-md leading-relaxed text-muted">
        {{ $text ?? __('Our editors are preparing new guides for this section. Check back soon.') }}
    </p>
    <a href="{{ route('home') }}" wire:navigate class="btn-ghost mt-8">{{ __('Back to the homepage') }}</a>
</div>
