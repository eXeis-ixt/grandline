<?php

namespace Database\Seeders;

use App\Models\Sea;
use App\Models\Crew;
use App\Models\CrewMember;
use Illuminate\Database\Seeder;

class PirateSeeder extends Seeder
{
    public function run(): void
    {
        $seas = [
            [
                'name' => 'East Blue',
                'description' => 'The weakest of all seas, but home to many ambitious pirates',
                'crews' => [
                    [
                        'name' => 'Ryujin Pirates',
                        'description' => 'Dragons of the Sea',
                        'members' => [
                            [
                                'name' => 'Ryujin D. Kai',
                                'role' => 'Captain',
                                'bounty' => 500000000
                            ],
                            [
                                'name' => 'Azure Storm',
                                'role' => 'Vice Captain',
                                'bounty' => 320000000
                            ],
                            [
                                'name' => 'Luna Wave',
                                'role' => 'Navigator',
                                'bounty' => 150000000
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Grand Line Paradise',
                'description' => 'The first half of the Grand Line, where dreams begin',
                'crews' => [
                    [
                        'name' => 'Arashi Pirates',
                        'description' => 'Masters of the Storm',
                        'members' => [
                            [
                                'name' => 'Storm D. Thunder',
                                'role' => 'Captain',
                                'bounty' => 750000000
                            ],
                            [
                                'name' => 'Lightning Bolt Jin',
                                'role' => 'Vice Captain',
                                'bounty' => 480000000
                            ],
                            [
                                'name' => 'Wind Walker Mai',
                                'role' => 'Navigator',
                                'bounty' => 200000000
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'New World',
                'description' => 'The second half of the Grand Line, where legends are made',
                'crews' => [
                    [
                        'name' => "Hell's Tenant Pirates",
                        'description' => 'Rulers of the Underworld',
                        'members' => [
                            [
                                'name' => 'Demon King Asura',
                                'role' => 'Captain',
                                'bounty' => 1500000000
                            ],
                            [
                                'name' => 'Shadow Blade Kuro',
                                'role' => 'Vice Captain',
                                'bounty' => 890000000
                            ],
                            [
                                'name' => "Hell's Compass Rose",
                                'role' => 'Navigator',
                                'bounty' => 450000000
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($seas as $seaData) {
            $sea = Sea::create([
                'name' => $seaData['name'],
                'description' => $seaData['description']
            ]);

            foreach ($seaData['crews'] as $crewData) {
                $crew = $sea->crews()->create([
                    'name' => $crewData['name'],
                    'description' => $crewData['description']
                ]);

                foreach ($crewData['members'] as $memberData) {
                    $crew->members()->create($memberData);
                }
            }
        }
    }
} 