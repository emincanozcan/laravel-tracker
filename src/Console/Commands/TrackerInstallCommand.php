<?php

namespace Emincan\Tracker\Console\Commands;

use Illuminate\Console\Command;

class TrackerInstallCommand extends Command
{
    protected $signature = 'tracker:install';

    protected $description = 'Install Tracker & publish config and assets.';

    public function handle()
    {
        $this->comment('Publishing Tracker Config');
        $this->callSilent('vendor:publish', ['--tag' => 'tracker-config']);

        $this->comment('Publishing Tracker Dashboard Assets');
        $this->callSilent('vendor:publish', ['--tag' => 'tracker-assets']);

        $this->info("Tracker installed successfully.");
        return 0;
    }
}
