<x-app-layout>

    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold my-8 dark:text-gray-300">Benvenuto, {{ auth()->user()->name }}!</h1>
    </div>

    <div class="py-6 pb-20">
        @livewire('dashboard-messages')
    </div>
</x-app-layout>
