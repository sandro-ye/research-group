<div class="max-w-7xl mx-auto px-4">

    <h1 class="text-3xl font-bold my-8 dark:text-gray-200">Gestione Avvisi</h1>

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

        <button type="button" wire:click="create"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            + Nuovo
        </button>
    </div>

    <!-- LISTA -->
    <div class="space-y-6">
        @forelse($this->announcements as $announcement)

            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6">

                <!-- Header -->
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $announcement->title }}
                    </h2>

                    <span class="text-sm">
                        @if($announcement->is_active)
                            <span class="text-green-600">Attivo</span>
                        @else
                            <span class="text-gray-500">Disattivo</span>
                        @endif
                    </span>
                </div>

                <!-- Contenuto -->
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    {{ Str::limit($announcement->content, 150) }}
                </p>

                <!-- Azioni -->
                <div class="mt-4 space-x-3">
                    <button type="button" wire:click="edit({{ $announcement->id }})"
                            class="text-blue-500 px-3 py-1 rounded hover:underline">
                        Modifica
                    </button>

                    <button type="button" wire:click="confirmDelete({{ $announcement->id }})"
                            class="text-red-500 px-3 py-1 rounded hover:underline">
                        Elimina
                    </button>

                    <button type="button" wire:click="toggleActive({{ $announcement->id }})"
                            class="text-yellow-500 px-3 py-1 rounded hover:underline">
                        Toggle
                    </button>
                </div>

            </div>

        @empty
            <div class="text-gray-500">
                Nessun avviso trovato.
            </div>
        @endforelse
    </div>

    <!-- MODALE -->
    <x-modal wire:model="isOpen" maxWidth="md">
        <h2 class="text-xl mb-4 dark:text-gray-200">
            {{ $announcementId ? 'Modifica' : 'Nuovo' }} Avviso
        </h2>

        <input wire:model="title"
               placeholder="Titolo"
               class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <textarea wire:model="content"
                placeholder="Contenuto"
                class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>

        <!-- ATTIVO -->
        <label class="flex items-center gap-2 mb-4 dark:text-gray-200">
            <input type="checkbox" wire:model="is_active">
                Attivo
        </label>

        <div class="flex justify-end space-x-2">
            <button type="button" wire:click="closeModal"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Annulla
            </button>

            <button type="button" wire:click="save"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 active:scale-95 transition">
                Salva
            </button>
        </div>

    </x-modal>

    <!-- MODALE CONFERMA ELIMINAZIONE -->
    <x-modal wire:model="confirmingDelete" maxWidth="md">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Conferma Eliminazione
        </h2>

        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Sei sicuro di voler eliminare questo avviso? Questa azione è irreversibile.
        </p>

        <div class="flex justify-end gap-2">

            <button 
                type="button"
                wire:click="$set('confirmingDelete', false)"
                class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition"
            >
                Annulla
            </button>

            <button 
                type="button"
                wire:click="delete({{ $deleteId }})"
                class="bg-red-600 text-white px-4 py-2 rounded-lg 
                       hover:bg-red-700 active:scale-95 transition shadow"
            >
                Elimina
            </button>

        </div>
    </x-modal>
</div>