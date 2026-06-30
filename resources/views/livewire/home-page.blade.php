<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- INTRODUZIONE -->
    <div class="pt-10 bg-white dark:bg-gray-900 shadow-md rounded-2xl p-8 mb-10">

        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-200 mb-4">
            Gruppo di Ricerca – Università XYZ
        </h1>

        <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
            Il nostro gruppo di ricerca si occupa dello studio e dello sviluppo di soluzioni innovative 
            nei campi dell'informatica, dell'intelligenza artificiale e dei sistemi distribuiti. 
            Collaboriamo con università e aziende per affrontare sfide complesse e contribuire 
            all'avanzamento della conoscenza scientifica.
        </p>

        <p class="text-gray-600 dark:text-gray-300 mt-4 leading-relaxed">
            In questo portale è possibile consultare le nostre pubblicazioni scientifiche, 
            i progetti di ricerca attivi e conclusi, e rimanere aggiornati sulle attività 
            e opportunità offerte dal gruppo.
        </p>
    </div>

    
    <!-- Titolo -->
    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">
        Ultime Pubblicazioni
    </h1>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- COLONNA PRINCIPALE (Pubblicazioni) -->
        <div class="lg:col-span-2 space-y-6">

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
                />
            @endforeach
            
            <a href="{{ route('publications') }}" 
                class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm mt-4 block">
                Vedi tutte le pubblicazioni →
            </a>

        </div>

        <!-- SIDEBAR (Avvisi) -->
        <div class="space-y-6">

            <!-- Card avvisi -->
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6">

                <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
                    Avvisi
                </h2>

                <ul class="space-y-3 text-gray-600 dark:text-gray-300">

                    @forelse($this->announcements as $announcement)
                        <li class="border-b pb-2">
                            📢 <strong>{{ $announcement->title }}</strong><br>
                            {{ $announcement->content }}
                        </li>
                    @empty
                        <li class="text-gray-500">
                            Nessun avviso disponibile.
                        </li>
                    @endforelse

                </ul>
            </div>

            <!-- Card contatti -->
            <div class="bg-indigo-600 dark:bg-indigo-800 text-white shadow-md rounded-2xl p-6">

                <h2 class="text-xl font-semibold mb-4">
                    Contattaci
                </h2>

                <p class="text-sm mb-4">
                    Vuoi collaborare con il nostro gruppo di ricerca?
                </p>

                <a href="#contacts" class="bg-white dark:bg-gray-200 text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition active:scale-95 shadow-sm hover:shadow-md">
                    Vai ai contatti
                </a>
            </div>

        </div>

    </div>

    <!-- PROGETTI IN CORSO -->
    <div class="mb-12 pt-10">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-200">
                Progetti in corso
            </h1>

            <a href="{{ route('projects') }}" 
                class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                Vedi tutti →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($this->getActiveProjectsProperty() as $project)
                <x-project-card 
                    :id="$project->id"
                    :title="$project->title"
                    :description="$project->description"
                    :members="$project->members->pluck('name')->toArray()"
                    :start_date="$project->start_date"
                    :end_date="$project->end_date"
                />
            @endforeach

        </div>

    </div>

</div>