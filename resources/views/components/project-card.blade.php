@props(['id', 'title', 'description', 'members', 'start_date', 'end_date', 'canEdit' => false])

    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-4 sm:p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <!-- Titolo -->
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-3">
            {{ $title }}
        </h2>
        
        <!-- Membri -->
        <div class="mb-4">
            <span class="text-sm text-gray-500">Membri:</span>
            <div class="flex flex-wrap gap-2 mt-1">
                @foreach($members as $member)
                    <span class="bg-indigo-100 text-indigo-700 text-sm px-3 py-1 rounded-full">
                        {{ $member }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Descrizione -->
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            {{ $description }}
        </p>

        <!-- Date -->
        <div class="text-sm text-gray-500 mb-4">
            <p>
                📅 Inizio:
                {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
            </p>

            @if($end_date)
            <p>
                🏁 Fine:
                {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
            </p>
            @else
            <p class="text-green-600 font-medium">
                🟢 In corso
            </p>
            @endif
        </div>

        
        <a href="{{ route('projects.show', $id ) }}" class="block text-blue-600 hover:text-blue-800">
            Vedi dettagli →
        </a>

        <!-- AZIONI -->
        @if($canEdit)
            <div class="mt-4 space-x-3">

                <button type="button" wire:click="$dispatch('editProject', { id: {{ $id }} })"
                        class="text-blue-600 hover:underline">
                    Modifica
                </button>

                <button type="button" wire:click="$dispatch('deleteProject', { id: {{ $id }} })"
                        class="text-red-600 hover:underline">
                    Elimina
                </button>

            </div> 
        @endif
    </div>
