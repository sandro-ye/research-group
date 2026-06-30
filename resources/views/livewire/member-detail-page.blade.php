<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- PROFILO -->
    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-8 mb-10 flex flex-col md:flex-row gap-6">

        <!-- Immagine -->
        <img 
            src="{{ $user->profile_photo_url }}" 
            class="w-32 h-32 rounded-full object-cover"
        >

        <!-- Info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                {{ $user->name }}
            </h1>

            <p class="text-indigo-600 mt-1">
                {{ $user->academic_role ?? 'Ruolo accademico non specificato'}}
            </p>
        <!--
            <p class="text-gray-500 mt-2">
                {{ $user->field ?? 'Ambito non specificato' }}
            </p>
        -->
            <p class="mt-4 text-gray-600 dark:text-gray-300">
                {{ $user->bio }}
            </p>
        </div>
    </div>

    <!-- PUBBLICAZIONI -->
    <div class="mb-10">
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Pubblicazioni</h2>

        <div class="space-y-6">
            @forelse($user->publications as $pub)
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
                <p class="text-gray-500">Nessuna pubblicazione disponibile.</p>
            @endforelse
        </div>
    </div>

    <!-- PROGETTI ATTIVI -->
    <div class="mb-10">
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Progetti in corso</h2>

        <div class="grid md:grid-cols-2 gap-6">
            @forelse($this->activeProjects as $project)
                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow">
                    <h3 class="font-semibold dark:text-gray-200 text-lg">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                </div>
            @empty
                <p class="text-gray-500">Nessun progetto attivo.</p>
            @endforelse
        </div>
    </div>

    <!-- PROGETTI CONCLUSI -->
    <div>
        <h2 class="text-2xl dark:text-gray-200 font-semibold mb-4">Progetti conclusi</h2>

        <div class="grid md:grid-cols-2 gap-6">
            @forelse($this->completedProjects as $project)
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-2xl shadow">
                    <h3 class="dark:text-gray-200 font-semibold text-lg">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                </div>
            @empty
                <p class="text-gray-500">Nessun progetto concluso.</p>
            @endforelse
        </div>
    </div>

</div>