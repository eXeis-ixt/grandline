<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use Inertia\Inertia;

class CrewController extends Controller
{
    public function show(Crew $crew)
    {
        $crew->load(['members' => function($query) {
            $query->orderByDesc('bounty');
        }, 'sea']);

        return Inertia::render('Crews/Show', [
            'crew' => $crew,
        ]);
    }
} 