@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white/60 backdrop-blur-xl border border-white/80 shadow-[0_8px_32px_0_rgba(31,38,135,0.05)] ' . $class]) }}>
    {{ $slot }}
</div>