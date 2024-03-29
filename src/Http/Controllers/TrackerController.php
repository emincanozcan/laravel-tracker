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
        $totalCount = TrackerActivity::count();

        $countByTrackableTypes = TrackerActivity::selectRaw('count(*) as trackable_type_count, trackable_type as trackable_type')
            ->groupBy("trackable_type")
            ->get()
            ->map(function ($item) {
                $item->trackable_type_count = (int)$item->trackable_type_count;
                return $item;
            });;

        $countByAction = TrackerActivity::selectRaw('count(*) as action_count, action')
            ->groupBy("action")
            ->get()
            ->map(function ($item) {
                $item->action_count = (int)$item->action_count;
                return $item;
            });

        return response()->json([
            "total_count" => (int)$totalCount,
            "count_by_trackable_types" => $countByTrackableTypes,
            "count_by_action" => $countByAction
        ]);
    }

    public function lastActivities()
    {
        $data = TrackerActivity::when(
            request()->get('action'),
            fn ($query) => $query->where('action', request()->get('action'))
        )->when(
            request()->get('trackable_type'),
            fn ($query) => $query->where('trackable_type', request()->get('trackable_type'))
        )->when(
            request()->get('trackable_id'),
            fn ($query) => $query->where('trackable_id', request()->get('trackable_id'))
        )->when(
            request()->get('ip_address'),
            fn ($query) => $query->where('ip_address', request()->get('ip_address'))
        )->when(
            request()->get('request_id'),
            fn ($query) => $query->where('request_id', request()->get('request_id'))
        )->orderByDesc('created_at')->paginate(10);

        return response()->json($data);
    }

    public function filters()
    {
        $actions = TrackerActivity::selectRaw('DISTINCT action')->get()
            ->map(fn ($d) => $d['action']);
        $trackableTypes = TrackerActivity::selectRaw('DISTINCT trackable_type')->get()
            ->map(fn ($d) => $d['trackable_type']);
        return response()->json([
            'action' => $actions,
            'types' => $trackableTypes
        ]);
    }
}
