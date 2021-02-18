<?php

namespace Emincan\Tracker\Console\Commands;

use Emincan\Tracker\Models\TrackerActivity;
use Illuminate\Console\Command;

class TrackerClearCommand extends Command
{
    protected $signature = 'tracker:clear {--older-than-days=7} {--chunk=5000} {--no-question}';

    protected $description = 'Clear old data to make dashboard fast & gain space on database.';

    public function handle()
    {
        $removeBeforeDate = now()->subDays($this->option('older-than-days'))->toDateTimeString();

        if (!$this->option('no-question')) {
            $confirmation = $this->confirm("Records created before {$this->option('older-than-days')} days will be deleted. Do you wish to continue?");
            if (!$confirmation) return 1;
        }

        $this->info("Deleting process is starting. Please wait until to see the success message.");

        $totalCount = TrackerActivity::count();
        $totalDeletedCount = 0;
        do {
            $deletedRows = TrackerActivity::where('created_at', '<=', $removeBeforeDate)
                ->limit($this->option('chunk'))->delete();
            $totalDeletedCount += $deletedRows;
            $this->info("Status: {$totalDeletedCount} / {$totalCount} deleted.");
        } while ($deletedRows > 0);

        $this->info("Records are deleted successfully.");
        return 0;
    }
}
