<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Titolo -->
    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 my-8">
        Membri del Gruppo
    </h1>

    <!-- Descrizione -->
    <p class="text-gray-600 dark:text-gray-300 mb-10">
        Scopri i membri del nostro gruppo di ricerca, le loro competenze e le aree di studio.
    </p>

    <!-- Grid membri -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($members as $member)
            <x-member-card 
                :id="$member['id']"
                :name="$member['name']"
                :role="$member['role']"
                :field="$member['field']"
                :bio="$member['bio']"
                :image="$member['image']"
            />
        @endforeach

    </div>

</div>