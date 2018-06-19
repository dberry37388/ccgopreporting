<?php

namespace App\Http\Controllers;

use App\Voter;

class WalkingListController extends Controller
{
    public function chart()
    {
        $republicanTotals = [];
        $democratTotals = [];
        
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($republicanTotals, $this->getVotesByElection($election, 'republican'));
        }
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($democratTotals, $this->getVotesByElection($election, 'democrat'));
        }
        
        return view('chart', compact('republicanTotals', 'democratTotals'));
    }
    
    protected function getVotesByElection($election, $party, $precinct = null)
    {
        return Voter::whereIn($election, config("votelist.vote_types.{$party}"))
            ->count();
    }
}
