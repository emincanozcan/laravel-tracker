<?php


namespace Emincan\Tracker\Http\Controllers;


use Emincan\Tracker\Models\TrackerActivity;

class TrackerController
{
    public function index()
    {
        return view('tracker::dashboard');
    }
    public function activityStatistics()
    {
        $startTime = now()->subDays(7)->toDateTimeString();
        $endTime = now()->toDateTimeString();

        $totalCount = TrackerActivity::where("created_at", "<", $endTime)->where("created_at", ">", $startTime)->count();

        $countByTrackableTypes = TrackerActivity::where("created_at", "<", $endTime)->where("created_at", ">", $startTime)
            ->selectRaw('count(*) as trackable_type_count, trackable_type as trackable_type')
            ->groupBy("trackable_type")->get();

        $countByAction = TrackerActivity::where("created_at", "<", $endTime)->where("created_at", ">", $startTime)
            ->selectRaw('count(*) as action_count, action')
            ->groupBy("action")->get();

        return response()->json([
            "total_count" => $totalCount,
            "count_by_trackable_types" => $countByTrackableTypes,
            "count_by_action" => $countByAction
        ]);
    }
    public function lastActivities()
    {
        return response()->json(TrackerActivity::paginate(2));
    }
}
