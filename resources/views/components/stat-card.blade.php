@props(['label' => '', 'value' => 0, 'color' => 'blue'])
@php
    $map = [
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'ring' => 'ring-blue-100'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-100'],
        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'ring-amber-100'],
        'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'ring' => 'ring-indigo-100'],
    ];
    $c = $map[$color] ?? $map['blue'];
@endphp
<div class="group relative overflow-hidden rounded-xl bg-white border border-gray-100 p-5 shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5">
    <div class="flex items-center gap-4">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full {{ $c['bg'] }} {{ $c['text'] }} ring-1 {{ $c['ring'] }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">{{ $label }}</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $value }}</p>
        </div>
    </div>
</div>

