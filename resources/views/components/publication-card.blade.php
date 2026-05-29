@props(['id', 'title', 'body', 'authors', 'canEdit' => false, 'interactive' => false])
<div>
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">    

    <!-- Titolo -->
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-3">
        {{ $title }}
    </h2>

    <!-- Autori -->
    <div class="mb-4">
        <span class="text-sm text-gray-500">Autori:</span>
        <div class="flex flex-wrap gap-2 mt-1">
            @foreach($authors as $author)
                <span class="bg-indigo-100 text-indigo-700 text-sm px-3 py-1 rounded-full">
                    {{ $author }}
                </span>
            @endforeach
        </div>
    </div>

    <!-- Corpo -->
    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
        {{ $abstract }}
    </p>

    <p class="text-sm text-gray-500 mt-4">
        Anno di pubblicazione: {{ $year }}
    </p>


    @if($doi)
    <a href="https://doi.org/{{ $doi }}" target="_blank" class="text-indigo-600 hover:underline">
        Visualizza pubblicazione →
    </a>
    @endif

    <!-- AZIONI -->
    @if($canEdit)
        <div class="mt-4 space-x-3">
            @if($interactive)

            <button type="button" wire:click="$dispatch('editPublication', { id: {{ $id }} })"
                    class="text-blue-600 hover:underline">
                Modifica
            </button>

            <button type="button" wire:click="$dispatch('deletePublication', { id: {{ $id }} })"
                    class="text-red-600 hover:underline">
                Elimina
            </button>

            @else
            <a href="{{ route('admin.publications') }}" 
                    class="text-blue-600 hover:underline">
                Modifica
            </a>

            @endif

        </div>
    @endif

    </div>
</div>