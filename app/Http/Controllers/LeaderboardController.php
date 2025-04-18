<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Sea;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index()
    {
        $crews = Crew::with('members')
            ->withStats()
            ->orderByTotalBounty()
            ->get();

        $seas = Sea::all();

        return Inertia::render('Leaderboard', [
            'crews' => $crews,
            'seas' => $seas,
        ]);
    }
} 