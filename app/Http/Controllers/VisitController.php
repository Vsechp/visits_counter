<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::all();


        $stats = Visit::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get();

        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        return view('visits.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ip' => 'required|string',
            'city' => 'required|string',
            'device' => 'required|string',
        ]);

        Visit::create($data);

        return redirect()->route('visits.index');
    }

    public function showStats(Request $request)
    {
        $hourlyStats = $this->getHourlyStats();
        $cityStats = $this->getCityStats();

        return view('stats', [
            'hourlyStats' => $hourlyStats,
            'cityStats' => $cityStats,
        ]);
    }

    private function getHourlyStats()
    {
        $hourlyStats = DB::table('visits')
            ->select(DB::raw('strftime("%H", created_at) AS hour'), DB::raw('COUNT(*) AS total'))
            ->groupBy(DB::raw('strftime("%H", created_at)'))
            ->orderBy(DB::raw('strftime("%H", created_at)'))
            ->get();

        return $hourlyStats;
    }

    private function getCityStats()
    {
        $cityStats = Visit::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get();

        return $cityStats;
    }


}
