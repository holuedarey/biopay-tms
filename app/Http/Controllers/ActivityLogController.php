<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index( Request $request )
    {
        $request->user()->can( 'read admin' );

        $activities = Activity::latest()->paginate(20);

        return view('pages.activity.index', compact('activities') );
    }

    public function show( Activity $activity )
    {
        $current = $activity->properties['attributes'];

        if ( isset( $activity->properties['old'] )) {
            $old = $activity->properties['old'];

            return view('pages.activity.show', compact('activity', 'old' , 'current'));
        }

        return view('pages.activity.show', compact('activity' , 'current'));
    }
}
