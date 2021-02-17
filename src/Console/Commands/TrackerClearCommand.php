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
            $confirmation = $this->ask("Tracker records that are created before {$removeBeforeDate} will be deleted.\n Type 'yes' and press enter if you want to proceed");
            if ($confirmation !== "yes") return 0;
        }

        $this->info("Deleting process is starting. Please wait until to see the success message.");

        $totalCount = TrackerActivity::count();
        $totalDeletedCount = 0;

        do {
            $deletedRows = TrackerActivity::where('created_at', '<', $removeBeforeDate)
                ->limit($this->option('chunk'))->delete();
            $totalDeletedCount += $deletedRows;
            $this->info("Status: {$totalDeletedCount} / {$totalCount} deleted.");
        } while ($deletedRows > 0);

        $this->info("Records are deleted successfully.");
        return 0;
    }
}
