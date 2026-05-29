<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- TITOLO -->
    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 my-8">
        Progetti di Ricerca
    </h1>

    <!-- DESCRIZIONE -->
    <p class="text-gray-600 dark:text-gray-300 mb-10">
        Esplora i progetti attivi e conclusi del nostro gruppo di ricerca.
    </p>

    <!-- PROGETTI ATTIVI -->
    <div class="mb-12">
        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-semibold pt-2 text-indigo-600">
                Progetti in corso
            </h2>
            
            @auth
                @if (auth()->user()->isAdmin() || auth()->user()->isDocente())
                    <a href="{{ route('admin.projects') }}"
                        class="bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition">  
                        Gestisci Progetti
                    </a>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($this->activeProjects as $project)
                <x-project-card 
                    :id="$project->id"
                    :title="$project->title"
                    :description="$project->description"
                    :members="$project->members->pluck('name')"
                    :start_date="$project->created_at"
                    :end_date="$project->end_date"
                    :canEdit="$project->canBeEditedBy(auth()->user())"
                />
            @empty
                <p class="text-gray-500">Nessun progetto attivo.</p>
            @endforelse
        </div>
    </div>

    <!-- PROGETTI CONCLUSI -->
    <div>
        <h2 class="text-2xl font-semibold mb-6 text-gray-700 dark:text-gray-300">
            Progetti conclusi
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($this->completedProjects as $project)
                <x-project-card 
                    :id="$project->id"
                    :title="$project->title"
                    :description="$project->description"
                    :members="$project->members->pluck('name')"
                    :start_date="$project->created_at"
                    :end_date="$project->end_date"
                    :canEdit="$project->canBeEditedBy(auth()->user())"
                />
            @empty
                <p class="text-gray-500">Nessun progetto concluso.</p>
            @endforelse
        </div>
    </div>
    
    <x-modal wire:model="isOpen" maxWidth="lg">

        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            {{ $projectId ? 'Modifica Progetto' : 'Nuovo Progetto' }}
        </h2>

        <!-- TITOLO -->
        <input type="text"
               wire:model="title"
               placeholder="Titolo"
               class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <!-- DESCRIZIONE -->
        <textarea wire:model="description"
                  placeholder="Descrizione"
                  class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>

        <!-- DATA INIZIO -->
        <p class="font-semibold mb-1 text-gray-700 dark:text-gray-200">
            Data Inizio
        <input type="date"
               wire:model="start_date"
               class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 text-black font-light">

        <!-- DATA FINE -->
        <p class="font-semibold mb-1 text-gray-700 dark:text-gray-200">
            Data Fine
        <input type="date"
               wire:model="end_date"
               class="w-full mb-4 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 text-black font-light">

        <!-- MEMBRI -->
        <div class="mb-4">
            <p class="font-semibold mb-2 text-gray-700 dark:text-gray-200">
                Membri
            </p>

            <div class="max-h-40 overflow-y-auto space-y-1 border rounded-lg p-2">
                @foreach($users as $user)
                    <label class="flex items-center gap-2 text-sm dark:text-gray-200">
                        <input type="checkbox"
                               value="{{ $user->id }}"
                               wire:model="selectedMembers"
                               class="rounded text-indigo-600 focus:ring-indigo-500">

                        {{ $user->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- PUBBLICAZIONE -->
        @if($end_date)
        <div class="mb-4">
            <p class="font-semibold mb-1 text-gray-700 dark:text-gray-200">
                Pubblicazione
            </p>

            <select wire:model="selectedPublication"
                    class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Nessuna --</option>

                @foreach($publications as $pub)
                    <option value="{{ $pub->id }}">
                        {{ $pub->title }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- ACTIONS -->
        <div class="flex justify-end gap-2 mt-4">

            <button type="button" wire:click="$set('isOpen', false)"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Annulla
            </button>

            <button type="button" wire:click="save"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg
                           hover:bg-green-700 active:scale-95 transition shadow">
                Salva
            </button>

        </div>

    </x-modal>

    <!-- MODALE CONFERMA ELIMINAZIONE -->
    <x-modal wire:model="confirmingDelete" maxWidth="md">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Conferma Eliminazione
        </h2>

        <p class="text-gray-600 dark:text-gray-300">
            Sei sicuro di voler eliminare questo progetto?
        </p>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" wire:click="$set('confirmingDelete', false)"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Annulla
            </button>

            <button type="button" wire:click="delete"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg
                           hover:bg-red-700 active:scale-95 transition shadow">
                Elimina
            </button>
        </div>
    </x-modal>

</div>