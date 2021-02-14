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
}
