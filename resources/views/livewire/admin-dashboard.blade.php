<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 my-8">
        Dashboard Admin
    </h1>

    <!-- STATISTICHE -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold dark:text-gray-200">{{ $usersCount }}</h2>
            <p class="text-gray-500">Membri</p>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold dark:text-gray-200">{{ $publicationsCount }}</h2>
            <p class="text-gray-500">Pubblicazioni</p>
        </div>

        <div class="bg-white dark:bg-gray-900    p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold dark:text-gray-200">{{ $projectsCount }}</h2>
            <p class="text-gray-500">Progetti</p>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold dark:text-gray-200">{{ $announcementsCount }}</h2>
            <p class="text-gray-500">Avvisi</p>

        </div>

    </div>

    <!-- AZIONI -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <a href="{{ route('admin.members') }}" class="bg-indigo-600 text-white p-6 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            👥 Gestisci Membri
        </a>

        <a href="{{ route('admin.publications') }}" class="bg-indigo-600 text-white p-6 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            📄 Gestisci Pubblicazioni
        </a>

        <a href="{{ route('admin.projects') }}" class="bg-indigo-600 text-white p-6 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            🔬 Gestisci Progetti
        </a>
        
        <a href="{{ route('admin.announcements') }}" class="bg-indigo-600 text-white p-6 rounded-lg hover:bg-indigo-700 active:scale-95 transition shadow-sm hover:shadow-md">
            📢 Gestisci Avvisi
        </a>

    </div>

</div>