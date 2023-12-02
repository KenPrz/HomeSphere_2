<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ModeSchedule;
use App\Models\Mode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ScheduledEventHandler;

class CheckForScheduledModes extends Command
{
    public $eventHandler;
    public function __construct(ScheduledEventHandler $eventHandler)
    {
        parent::__construct();
        $this->eventHandler = $eventHandler;
    }
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
        $currentTime = Carbon::now('Asia/Manila');
        $scheduledModes = ModeSchedule::where('start_time', '<=', $currentTime->format('H:i:s'))
            ->where('end_time', '>=', $currentTime->format('H:i:s'))
            ->get();    
        foreach ($scheduledModes as $mode) {
            $this->eventHandler->handleSchedule($mode);
        }
    }
    
}
