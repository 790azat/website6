{{--
    Cover area for an article card: the article image when it exists,
    otherwise a warm paper panel with the section icon. Expects $article; optional $iconClass.
--}}
@if ($article['image'])
    <img
        src="{{ asset('images/'.$article['image']) }}"
        alt="{{ $article['title'] }}"
        loading="lazy"
        decoding="async"
        class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-[1.02]"
    />
@else
    <div class="absolute inset-0 bg-soft"></div>
    <flux:icon name="{{ $article['section_icon'] }}" variant="outline" class="relative {{ $iconClass ?? 'size-12' }} text-zinc-400" />
@endif
