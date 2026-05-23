@props([
    'model' => 'open',   // variabile Livewire/Alpine
    'maxWidth' => 'md'   // sm, md, lg, xl
])

@php
$maxWidthClass = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
][$maxWidth];
@endphp

<div 
    x-data="{ open: @entangle($attributes->wire('model')).live }"
    x-show="open"
    x-transition.opacity
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center"
>

    <!-- BACKDROP -->
    <div 
        class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
        @click="open = false"
    ></div>

    <!-- MODAL -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="relative w-full {{ $maxWidthClass }} bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6"
    >
        {{ $slot }}
    </div>

</div>