<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;
use App\Models\User;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Nessun utente trovato. Crea prima utenti.');
            return;
        }

        // Lista pubblicazioni
        $publications = [
            [
                'title' => 'Deep Learning per l’Analisi dei Dati',
                'abstract' => 'Studio sull’utilizzo delle reti neurali profonde per analizzare grandi dataset.',
                'doi' => '10.1000/dl001',
            ],
            [
                'title' => 'Sistemi Distribuiti Scalabili',
                'abstract' => 'Analisi delle architetture distribuite moderne e delle loro prestazioni.',
                'doi' => '10.1000/sd002',
            ],
            [
                'title' => 'AI in ambito sanitario',
                'abstract' => 'Applicazioni dell’intelligenza artificiale nella diagnosi medica.',
                'doi' => '10.1000/ai003',
            ],
            [
                'title' => 'Big Data Analytics',
                'abstract' => 'Tecniche avanzate per l’analisi dei big data.',
                'doi' => '10.1000/bd004',
            ],
        ];

        foreach ($publications as $pubData) {

            $publication = Publication::create($pubData);

            // 🔥 Associa 1-3 autori casuali
            $randomUsers = $users->random(rand(1, min(3, $users->count())));

            $publication->user()->attach($randomUsers->pluck('id')->toArray());
        }
    }
}
