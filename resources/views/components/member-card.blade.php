@props(['id', 'name', 'role', 'field', 'bio', 'image'])
<a href="{{ route('members.show', $id) }}">
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center">

        <!-- Immagine -->
        <img 
            src="{{ $image }}" 
            alt="{{ $name }}"
            class="w-24 h-24 mx-auto rounded-full mb-4 object-cover border-4 dark:border-indigo-600">
        >

        <!-- Nome -->
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $name }}
        </h2>

        <!-- Ruolo -->
        <p class="text-indigo-600 text-sm mb-2">
            {{ $role }}
        </p>

        <!-- Ambito -->
        <p class="text-gray-500 text-sm mb-3">
            {{ $field }}
        </p>

        <!-- Bio -->
        <p class="text-gray-600 dark:text-gray-300 text-sm">
            {{ $bio }}
        </p>

    </div>
</a>