<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::create([
            'title' => 'Nuovo bando',
            'content' => 'Nuovo bando di ricerca aperto per collaborazioni internazionali.',
        ]);

        Announcement::create([
            'title' => 'Seminario AI',
            'content' => 'Seminario il 15 Maggio su Intelligenza Artificiale.',
        ]);

        Announcement::create([
            'title' => 'Dottorato 2025',
            'content' => 'Aperte le candidature per dottorato 2025.',
        ]);
    }
}