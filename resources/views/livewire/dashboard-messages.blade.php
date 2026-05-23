<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- FORM -->
    <div class="bg-white p-4 shadow mb-6 rounded-2xl dark:bg-gray-900">
        <h2 class="text-lg font-bold mb-4 dark:text-gray-300">Nuovo messaggio</h2>

        <textarea wire:model="content"
                  class="w-full border rounded-lg p-3 mb-4 dark:bg-gray-200"
                  placeholder="Scrivi un messaggio..."></textarea>

        <select wire:model="project_id" class="w-full border p-3 mb-4 rounded-lg dark:bg-gray-200 ">
            <option value="">-- Generale --</option>
            @foreach($this->getProjectsProperty() as $project)
                <option value="{{ $project->id }}">
                    {{ $project->title }}
                </option>
            @endforeach
        </select>

        <button type="button" wire:click="send"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            Invia
        </button>
    </div>

    <!-- FILTRI -->
    <div class="bg-white dark:bg-gray-900 p-4 rounded-2xl shadow mb-8 grid grid-cols-1 md:grid-cols-1 gap-4">

        <!-- Filtro anno -->
        <select wire:model.live="filteredProjectId" class="rounded-lg border-gray-300 dark:bg-gray-200">
            <option value="">-- Tutti i messaggi --</option>
            @foreach($this->getProjectsProperty() as $project)
                <option value="{{ $project->id }}">
                    {{ $project->title }}
                </option>
            @endforeach
        </select>
    </div>


    <!-- LISTA MESSAGGI -->
    <div wire:poll.5s class="space-y-4">
        @foreach($this->getMessagesProperty() as $message)
            <div class="bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                <div class="flex justify-between text-sm text-gray-500">
                    <span class="font-semibold">{{ $message->user->name }}</span>
                    <span>{{ $message->created_at->diffForHumans() }}</span>
                </div>

                @if($message->project)
                    <div class="text-xs text-indigo-600 mb-1">
                        📌 {{ $message->project->title }}
                    </div>
                @endif

                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $message->content }}</p>

            </div>
        @endforeach
    </div>

</div>