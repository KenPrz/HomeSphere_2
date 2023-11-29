<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckForScheduledModes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modes:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for scheduled modes and activate them if necessary.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo 'it works i guess';
    }
}
