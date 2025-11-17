@props(['href' => '#', 'title' => '', 'desc' => '', 'color' => 'blue'])
@php
    $map = [
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'accent' => 'text-blue-700'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'accent' => 'text-emerald-700'],
        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'accent' => 'text-amber-700'],
        'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'accent' => 'text-indigo-700'],
    ];
    $c = $map[$color] ?? $map['blue'];
@endphp
<a href="{{ $href }}" class="group block rounded-xl bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5">
    <div class="flex items-start gap-4">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg {{ $c['bg'] }} {{ $c['text'] }} ring-1 ring-white/50">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
        <div class="flex-1">
            <h4 class="text-base font-semibold text-gray-900">{{ $title }}</h4>
            <p class="mt-1 text-sm text-gray-500">{{ $desc }}</p>
            <span class="mt-3 inline-flex items-center text-sm font-medium {{ $c['accent'] }} group-hover:underline">Buka
                <svg class="ml-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
            </span>
        </div>
    </div>
</a>
