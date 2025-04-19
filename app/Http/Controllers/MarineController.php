<?php

namespace App\Http\Controllers;

use App\Models\Marine;
use Inertia\Inertia;

class MarineController extends Controller
{
    private $rankOrder = [
        'Fleet Admiral' => 1,
        'Admiral' => 2,
        'Vice Admiral' => 3,
        'Rear Admiral' => 4,
        'Commodore' => 5,
        'Captain' => 6,
        'Commander' => 7,
        'Lieutenant Commander' => 8,
        'Lieutenant' => 9,
        'Warrant Officer' => 10,
        'Sergeant Major' => 11,
        'Sergeant' => 12,
        'Corporal' => 13,
        'Seaman First Class' => 14,
        'Seaman Apprentice' => 15,
        'Seaman Recruit' => 16
    ];

    public function index()
    {
        $marines = Marine::with('sea')->get();
        
        $marines = $marines->sortBy(function ($marine) {
            return $this->rankOrder[$marine->rank] ?? 999;
        });

        return Inertia::render('Marines/Index', [
            'marines' => $marines->values()
        ]);
    }

    public function show(Marine $marine)
    {
        $marine->load('sea');

        return Inertia::render('Marines/Show', [
            'marine' => $marine
        ]);
    }
}
