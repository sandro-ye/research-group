<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm fixed w-full z-50 top-0">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- SINISTRA: Nome sito -->
            <div class="flex items-center">
                <a href="{{ route('homepage') }}" class="text-2xl font-bold text-indigo-600">
                    ResearchGroup
                </a>
            </div>

            <!-- CENTRO / DESTRA: Link principali -->
            <div class="hidden sm:flex sm:items-center space-x-8">

                <a href="{{ route('members') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition">
                    Membri
                </a>

                <a href="{{ route('projects') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition">
                    Progetti
                </a>

                <a href="{{ route('publications') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition">
                    Pubblicazioni
                </a>

            </div>

            <!-- DESTRA: Auth -->
            <div class="hidden sm:flex sm:items-center space-x-4">
                <div x-data="{
                    dark: document.documentElement.classList.contains('dark'),
                        toggle() {
                            this.dark = !this.dark;
                            document.documentElement.classList.toggle('dark', this.dark);
                            localStorage.theme = this.dark ? 'dark' : 'light';
                        }
                    }"
                    class="flex items-center gap-2">

                <!-- ICONA -->
                <span x-text="dark ? '🌙' : '☀️'"></span>

                <!-- SWITCH -->
                <button @click="toggle"
                    class="relative inline-flex items-center h-6 w-11 
                      bg-gray-300 dark:bg-gray-600 
                        rounded-full transition">

                    <span 
                        :class="dark ? 'translate-x-6 bg-indigo-500' : 'translate-x-1 bg-white'"
                        class="inline-block w-4 h-4 transform rounded-full transition">
                    </span>

                </button>

            </div>

                @auth
                <!-- Dashboard utente (Jetstream) -->
                <a href="{{ route('dashboard') }}" class="text-indigo-600 font-semibold hover:underline">
                    Dashboard
                </a>

                <!-- Dashboard ADMIN -->
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" 
                    class="text-red-600 font-semibold hover:underline">
                    Admin
                </a>
                @endif

                
                <!-- LOGOUT -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-gray-700 dark:text-gray-300 hover:text-red-600 transition">
                        Logout
                    </button>
                </form>

                @else
                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                    Accedi
                </a>

                @endauth

            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">

                <!-- DARK MODE TOGGLE MOBILE -->
                <div x-data="{
                    dark: document.documentElement.classList.contains('dark'),
                    toggle() {
                            this.dark = !this.dark;
                            document.documentElement.classList.toggle('dark', this.dark);
                            localStorage.theme = this.dark ? 'dark' : 'light';
                        }
                    }"
                    class="flex items-center gap-1 px-4">

                    <!-- ICONA -->
                    <span class="text-sm" x-text="dark ? '🌙' : '☀️'"></span>

                    <!-- SWITCH -->
                    <button @click="toggle"
                        class="relative inline-flex items-center h-6 w-11 
                    bg-gray-300 dark:bg-gray-600 
                        rounded-full transition">

                        <span 
                            :class="dark ? 'translate-x-6 bg-indigo-500' : 'translate-x-1 bg-white'"
                            class="inline-block w-4 h-4 transform rounded-full transition">
                        </span>

                    </button>
                </div>
                
                <button @click="open = ! open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MENU MOBILE -->
    <div x-show="open" x-transition class="sm:hidden px-4 pb-4 space-y-2"
         @click.away="open = false">
        

        <a href="{{ route('members') }}" class="block py-2 text-gray-700 dark:text-gray-300">Membri</a>
        <a href="{{ route('projects') }}" class="block py-2 text-gray-700 dark:text-gray-300">Progetti</a>
        <a href="{{ route('publications') }}" class="block py-2 text-gray-700 dark:text-gray-300">Pubblicazioni</a>

        <div class="border-t my-2"></div>

        @auth
            <a href="{{ route('dashboard') }}" class="block py-2 text-indigo-600">Dashboard</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="block py-2 text-red-600">Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block py-2 text-gray-700 dark:text-gray-300">
                    Logout
                </button>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-gray-700 dark:text-gray-300">Accedi</a>
        @endauth

    </div>
</nav>