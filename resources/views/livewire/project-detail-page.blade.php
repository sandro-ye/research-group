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

    <!-- PUBBLICAZIONE COLLEGATA -->
    <div>
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Pubblicazione correlata</h2>

        @if($project->isCompleted() && $project->publication)
            <div class="space-y-6">
                <x-publication-card 
                    :id="$project->publication->id"
                    :title="$project->publication->title"
                    :body="$project->publication->abstract"
                    :authors="$project->publication->authors->pluck('name')->join(', ')"
                />
            </div>
        @else
            <p class="text-gray-500">Nessuna pubblicazione associata.</p>
        @endif
    </div>
</div>