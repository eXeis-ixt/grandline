<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Marine;
use App\Models\Sea;

class MarineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newWorld = Sea::where('name', 'New World')->first();
        $grandLine = Sea::where('name', 'Grand Line Paradise')->first();
        
        Marine::create([
            'name' => 'Sakazuki Akainu',
            'rank' => 'Fleet Admiral',
            'description' => 'Current Fleet Admiral of the Marines, possessor of the Magu Magu no Mi.',
            'sea_id' => $newWorld->id,
            'status' => 'active',
            'division' => 'Marine Headquarters',
            'specialty' => 'Magma Devil Fruit User'
        ]);

        Marine::create([
            'name' => 'Kizaru Borsalino',
            'rank' => 'Admiral',
            'description' => 'Admiral of the Marines, possessor of the Pika Pika no Mi.',
            'sea_id' => $newWorld->id,
            'status' => 'active',
            'division' => 'Marine Headquarters',
            'specialty' => 'Light Devil Fruit User'
        ]);

        Marine::create([
            'name' => 'Monkey D. Garp',
            'rank' => 'Vice Admiral',
            'description' => 'Legendary Marine hero known as "Garp the Fist".',
            'sea_id' => $newWorld->id,
            'status' => 'retired',
            'division' => 'Marine Headquarters',
            'specialty' => 'Haki Master'
        ]);
    }
}
