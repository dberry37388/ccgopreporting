<?php

namespace App\Http\Controllers;

use App\Exports\WalkingListExport;

class WalkingListController extends Controller
{
    /**
     * Downloads the Walk List.
     *
     * @return \App\Exports\WalkingListExport
     */
    public function download()
    {
        return new WalkingListExport();
    }
}
