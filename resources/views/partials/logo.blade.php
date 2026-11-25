{{--
    Brand logo: the note mark plus the site name (config app.name) set in the serif.
    Options: $invert (bool) for dark backgrounds, $size ('sm' | 'md').
--}}
@php
    $invert = $invert ?? false;
    $small = ($size ?? 'md') === 'sm';
@endphp
<span class="inline-flex shrink-0 items-center gap-2.5">
    @include('partials.logo-mark', ['class' => $small ? 'size-6' : 'size-7'])
    <span @class([
        'font-serif leading-none font-medium tracking-[-0.02em]',
        'text-xl' => $small,
        'text-[1.65rem]' => ! $small,
        'text-white' => $invert,
        'text-ink' => ! $invert,
    ])>{{ config('app.name') }}</span>
</span>
