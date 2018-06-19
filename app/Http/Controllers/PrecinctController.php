<?php

namespace App\Http\Controllers;

use App\Voter;
use Illuminate\Http\Request;

class PrecinctController extends Controller
{
    public function show($precinct)
    {
        $voters = Voter::where('pct', $precinct)
            ->hasVoted()
            ->defaultOrderBy()
            ->paginate(50);
    
        $republicanTotals = [];
        $democratTotals = [];
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($republicanTotals, getVotesByElection($election, 'republican', $precinct));
        }
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($democratTotals, getVotesByElection($election, 'democrat', $precinct));
        }
        
        return view('precinct.index', compact('precinct', 'voters', 'republicanTotals', 'democratTotals'));
    }
}
