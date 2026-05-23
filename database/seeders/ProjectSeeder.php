<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Nessun utente trovato. Esegui prima UserSeeder.');
            return;
        }

        $projectsData = [
            [
                'title' => 'Artificial Intelligence for Healthcare',
                'description' => 'Applicazioni di AI per diagnosi medica e supporto decisionale.',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => null, // in corso
            ],
            [
                'title' => 'Cybersecurity and Privacy',
                'description' => 'Studio di tecniche avanzate per la sicurezza dei dati.',
                'start_date' => Carbon::now()->subYear(),
                'end_date' => Carbon::now()->subYear(),
            ],
            [
                'title' => 'Smart Cities and IoT',
                'description' => 'Soluzioni IoT per città intelligenti.',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => null,
            ],
            [
                'title' => 'Data Science for Social Good',
                'description' => 'Analisi dati per impatto sociale.',
                'start_date' => Carbon::now()->subYear(),
                'end_date' => Carbon::now()->subMonths(6),
            ],
        ];

        foreach ($projectsData as $data) {

            $project = Project::create($data);

            // 👥 assegna membri casuali (da 1 a 4)
            $members = $users->random(rand(1, min(4, $users->count())))->pluck('id');

            $project->members()->attach($members);
        }
    }
}
