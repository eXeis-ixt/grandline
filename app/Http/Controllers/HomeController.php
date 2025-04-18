<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Sea;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $seas = Sea::with(['crews' => function($query) {
            $query->withStats();
        }])->get();

        $topCrews = Crew::with('members')
            ->withStats()
            ->orderByTotalBounty()
            ->take(3)
            ->get();

        return Inertia::render('Home', [
            'seas' => $seas,
            'topCrews' => $topCrews
        ]);
    }
}
