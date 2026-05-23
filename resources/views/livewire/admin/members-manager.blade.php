<div class="max-w-7xl mx-auto px-4">

    <h1 class="text-3xl font-bold my-8 dark:text-gray-200">Gestione Membri</h1>

    <!-- MESSAGGI -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- TOOLBAR -->
    <div class="flex justify-between mb-6">
        <input type="text" wire:model.live="search"
               placeholder="Cerca membro..."
               class="border rounded-lg px-4 py-2 w-1/3 focus:ring-2 focus:ring-indigo-500 outline-none transition dark:bg-gray-300">

        <button type="button" wire:click="openModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            + Nuovo Membro
        </button>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow">
        <table class="w-full">
            <thead class="bg-gray-100 dark:bg-indigo-900">
                <tr>
                    <th class="p-3 text-left dark:text-gray-200">Foto</th>
                    <th class="text-left dark:text-gray-200">Nome</th>
                    <th class="text-left dark:text-gray-200">Email</th>
                    <th class="text-left dark:text-gray-200">Ruolo</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($members as $member)
                    <tr class="border-t">
                        <td class="p-3">
                            <img src="{{ $member->profile_photo_url }}"
                                 class="w-10 h-10 rounded-full">
                        </td>

                        <td class="dark:text-gray-200">{{ $member->name }}</td>
                        <td class="dark:text-gray-200">{{ $member->email }}</td>
                        <td class="dark:text-gray-200">{{ $member->role }}</td>

                        <td class="space-x-2">
                            <button type="button" wire:click="edit({{ $member->id }})"
                                    class="text-blue-600 hover:underline">
                                Modifica
                            </button>

                            <button type="button" wire:click="confirmDelete({{ $member->id }})"
                                    class="text-red-600 hover:underline">
                                Elimina
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MOBILE CARDS -->
    <div class="md:hidden space-y-4">
        @foreach($members as $member)

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow p-4">

            <!-- HEADER -->
            <div class="flex items-center gap-4 mb-3">
                <img src="{{ $member->profile_photo_url }}"
                     class="w-12 h-12 rounded-full">

                <div>
                    <h2 class="font-semibold dark:text-gray-200">
                        {{ $member->name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ $member->role }}
                    </p>
                </div>
            </div>

            <!-- INFO -->
            <div class="text-sm text-gray-600 dark:text-gray-300 mb-3 break-words">
                {{ $member->email }}
            </div>

            <!-- ACTIONS -->
            <div class="flex justify-end gap-4">
                <button type="button" wire:click="edit({{ $member->id }})"
                        class="text-blue-600 text-sm">
                    Modifica
                </button>

                <button type="button" wire:click="confirmDelete({{ $member->id }})"
                        class="text-red-600 text-sm">
                    Elimina
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- MODALE -->
    <x-modal wire:model="isOpen" maxWidth="md">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            {{ $memberId ? 'Modifica' : 'Nuovo' }} Membro
        </h2>

        <!-- NOME -->
        <input type="text" wire:model="name" placeholder="Nome"
                class="w-full mb-3 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <!-- EMAIL -->
        <input type="email" wire:model="email" placeholder="Email"
                class="w-full mb-2 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <!-- PASSWORD -->
        <input type="password" wire:model="password"
                placeholder="Password"
                class="w-full mb-2 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 ">

        <!-- RUOLO -->
        <select wire:model="role"
                class="w-full mb-2 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <option value="admin">Admin</option>
            <option value="docente">Docente</option>
            <option value="collaboratore">Collaboratore</option>
        </select>

        <!-- RUOLO ACCADEMICO -->
        <input wire:model="academic_role"
                placeholder="Ruolo accademico"
                class="w-full mb-2 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500">

        <!-- BIO -->
        <textarea wire:model="bio"
                placeholder="Bio"
                class="w-full mb-2 border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>

        <!-- FOTO -->
        <input type="file" wire:model="photo"
               class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition mb-4">

        <!-- AZIONI -->
        <div class="flex justify-end space-x-2">
            <button type="button" wire:click="closeModal"
                    class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Annulla
            </button>

            <button type="button" wire:click="store"
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

        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Sei sicuro di voler eliminare questo membro? Questa azione è irreversibile.
        </p>

        <div class="flex justify-end gap-2">

            <button type="button"
                wire:click="$set('confirmingDelete', false)"
                class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition"
            >
                Annulla
            </button>

            <button type="button"
                wire:click="delete"
                class="bg-red-600 text-white px-4 py-2 rounded-lg 
                       hover:bg-red-700 active:scale-95 transition shadow"
            >
                Elimina
            </button>

        </div>
    </x-modal>

</div>