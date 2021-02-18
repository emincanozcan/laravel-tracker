<?php


namespace Emincan\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerActivity extends Model
{
    protected $guarded = ["id"];
    const UPDATED_AT = null;
    protected $casts = [
        "additional_data" => "array"
    ];

    // public function scopeLastsByDays($query, $days)
    // {
    //     $startTime = now()->subDays($days)->toDateTimeString();
    //     $endTime = now()->toDateTimeString();
    //     return $query->where("created_at", "<", $endTime)->where("created_at", ">", $startTime);
    // }

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
