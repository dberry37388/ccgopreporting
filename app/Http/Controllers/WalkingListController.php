<?php

namespace App\Http\Controllers;

use App\Exports\MasterWalkList;

class WalkingListController extends Controller
{
    /**
     * Downloads the Walk List.
     *
     * @return \App\Exports\MasterWalkList
     */
    public function download()
    {
        return new MasterWalkList();
    }
}
