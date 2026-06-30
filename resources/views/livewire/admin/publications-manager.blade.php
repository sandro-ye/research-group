<div class="max-w-7xl mx-auto px-4">

    <h1 class="text-3xl font-bold my-8 dark:text-gray-200">Gestione Pubblicazioni</h1>

    <!-- MESSAGGI -->
    @if(session()->has('success'))
        <div class="bg-green-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- TOOLBAR -->
    <div class="flex justify-between mb-6">
        <input wire:model.live="search" placeholder="Cerca..."
               class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition shadow-sm hover:shadow-md dark:bg-gray-300">

        <button type="button" wire:click="openModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            + Nuova
        </button>
    </div>

    <!-- LISTA -->
    <div class="space-y-6">
        @foreach($publications as $pub)

        <x-publication-card 
            :id="$pub->id"
            :title="$pub->title"
            :abstract="Str::limit($pub->abstract, 120)"
            :year="$pub->year"
            :doi="$pub->doi"
            :authors="$pub->authors->pluck('name')->toArray()"
            :project="$pub->project?->title"
            :projectId="$pub->project?->id"
            :canEdit="$pub->canBeEditedBy(auth()->user())"
            :interactive="true"
        />

        @endforeach
    </div>

    <!-- MODALE -->
    <x-modal wire:model="isOpen" maxWidth="md">

        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            {{ $publicationId ? 'Modifica' : 'Nuova' }} Pubblicazione
        </h2>

        <input wire:model="title"
            placeholder="Titolo"
            class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <textarea wire:model="abstract"
            placeholder="Abstract"
            class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>

        <input wire:model="doi"
            placeholder="DOI"
            class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <!-- ANNO -->
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Anno di pubblicazione
            </label>

            <input
                type="number"
                wire:model="year"
                min="1900"
                max="{{ date('Y') }}"
                step="1"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                    dark:bg-gray-800 dark:text-gray-200
                    focus:ring-2 focus:ring-indigo-500"
                placeholder="{{ date('Y') }}">

            @error('year')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- AUTORI -->
        <div class="mb-4">
            <p class="font-semibold mb-2 text-gray-700 dark:text-gray-200">
                Autori
            </p>

            <div class="max-h-40 overflow-y-auto space-y-1 border rounded-lg p-2">
                @foreach($authors as $author)
                    <label class="flex items-center gap-2 text-sm dark:text-gray-200">
                        <input type="checkbox"
                               wire:model="selectedAuthors"
                               class="rounded text-indigo-600 focus:ring-indigo-500"
                               value="{{ $author->id }}">
                            
                        <span>{{ $author->name }}</span>
                        @if($author->role === 'docente')
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs">
                                Docente
                            </span>
                        @endif
                    </label>
                @endforeach
            </div>
            @error('selectedAuthors')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
            @enderror
        </div>

        <!-- PROGETTO -->
        <div class="space-y-2">

            <label class="font-semibold text-gray-700 dark:text-gray-300">
                Progetto associato
            </label>

            <select
                wire:model="selectedProject"
                class="w-full rounded-lg border border-gray-300
                    dark:border-gray-700
                    dark:bg-gray-800
                    dark:text-gray-200
                    px-3 py-2">

            <option value="">
                Nessun progetto
            </option>

            @foreach($projects as $project)
                <option value="{{ $project->id }}">
                    {{ $project->title }}
                </option>
            @endforeach

            </select>

            <p class="text-xs text-gray-500 dark:text-gray-400 pb-2">
                È possibile associare la pubblicazione ad uno dei progetti ancora in corso.
            </p>

        </div>


        <!-- PDF -->
        <input type="file" wire:model="pdf" class="mb-4">

        <div class="flex justify-end gap-2">
            <button type="button" wire:click="$set('isOpen', false)"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                Annulla
            </button>

            <button type="button" wire:click="store"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Salva
            </button>
        </div>

    </x-modal>

    <!-- MODALE CONFERMA ELIMINAZIONE -->
    <x-modal wire:model="confirmingDelete" maxWidth="md">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Conferma Eliminazione
        </h2>

        <p class="mb-4 text-gray-600 dark:text-gray-300">
            Sei sicuro di voler eliminare questa pubblicazione? Questa azione è irreversibile.
        </p>

        <div class="flex justify-end gap-2">
            <button type="button" wire:click="$set('confirmingDelete', false)"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                Annulla
            </button>

            <button type="button" wire:click="delete"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Elimina
            </button>
        </div>
    </x-modal>
</div>