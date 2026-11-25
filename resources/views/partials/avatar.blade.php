{{--
    Author avatar: photo when available, otherwise initials on soft blue.
    Expects $author (from SiteContent::author) and optional $class for size.
--}}
@php $class = $class ?? 'size-10 text-sm'; @endphp
@if ($author['photo'])
    <img
        src="{{ asset('images/'.$author['photo']) }}"
        alt="{{ $author['name'] }}"
        loading="lazy"
        decoding="async"
        class="{{ $class }} shrink-0 rounded-full object-cover ring-2 ring-white"
    />
@else
    <span class="{{ $class }} flex shrink-0 items-center justify-center rounded-full bg-soft font-serif text-ink ring-1 ring-line" aria-hidden="true">
        {{ $author['initials'] }}
    </span>
@endif
