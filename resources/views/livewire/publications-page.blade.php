<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- TITOLO -->
    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 my-8">
        Pubblicazioni
    </h1>

    <!-- DESCRIZIONE -->
    <p class="text-gray-600 dark:text-gray-300 mb-8">
        Consulta tutte le pubblicazioni scientifiche del nostro gruppo di ricerca.
    </p>

    <!-- FILTRI -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        <!-- Ricerca -->
        <input 
            type="text"
            wire:model.live="search"
            placeholder="Cerca per titolo..."
            class="rounded-lg px-4 py-2 outline-none transition border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-200"
        >

        <!-- Filtro anno -->
        <select wire:model.live="year" class="rounded-lg border-gray-300 px-4 py-2 outline-none transition focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-200">
            <option value="">Tutti gli anni</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>

        <!-- Reset -->
        <button wire:click="resetParameters()"
            class="bg-gray-200 dark:bg-gray-400 hover:bg-gray-300 rounded-lg px-4 py-2 active:scale-95 transition shadow-sm hover:shadow-md">
            Reset
        </button>
    </div>

    <!-- LISTA PUBBLICAZIONI -->
    <div class="space-y-6">

        @forelse($this->getFilteredPublicationsProperty() as $pub)
            <x-publication-card 
                :id="$pub->id"
                :title="$pub->title"
                :abstract="Str::limit($pub->abstract, 120)"
                :year="$pub->year"
                :doi="$pub->doi"
                :authors="$pub->authors->pluck('name')->toArray()"
                :canEdit="$pub->canBeEditedBy(auth()->user())"
            />
        @empty
            <div class="text-gray-500">
                Nessuna pubblicazione trovata.
            </div>
        @endforelse

    </div>

</div>