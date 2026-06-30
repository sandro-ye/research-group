<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HEADER PROGETTO -->
    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-8 mb-10">

        <!-- Titolo -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">
            {{ $project->title }}
        </h1>

        <!-- Stato -->
        <span class="inline-block px-3 py-1 text-sm rounded-full
            {{ $this->isActive ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
            {{ $this->isActive ? 'In corso' : 'Concluso' }}
        </span>

        <!-- Descrizione -->
        <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ $project->description }}
        </p>

    </div>

    <!-- MEMBRI -->
    <div class="mb-10">
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Membri del progetto</h2>

        <div class="flex flex-wrap gap-3">
            @foreach($project->members as $member)
                <a href="{{ route('members.show', $member->id) }}"
                   class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full hover:bg-indigo-200 transition">
                    {{ $member->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- PUBBLICAZIONI COLLEGATE -->
    <div>
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Pubblicazioni correlate</h2>

        @forelse($project->publications as $publication)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <x-publication-card
                :id="$publication->id"
                :title="$publication->title"
                :abstract="$publication->abstract"
                :year="$publication->year"
                :doi="$publication->doi"
                :authors="$publication->authors->pluck('name')->toArray()"
                :project="$project->title"
                :projectId="$project->id"
                :canEdit="$publication->canBeEditedBy(auth()->user())"
            />
        </div>

        @empty

        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6">

            <p class="text-gray-500 dark:text-gray-400">
                Nessuna pubblicazione è ancora stata associata a questo progetto.
            </p>

        </div>

        @endforelse
    </div>
</div>