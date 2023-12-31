<?php

namespace App\Console\Commands;
use App\Http\Controllers\ScheduledEventDeactivator;
use App\Models\ModeSchedule;
use App\Models\Mode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class DeactivateScheduledModes extends Command
{
    public $eventDeactivator;
    public function __construct(ScheduledEventDeactivator $eventDeactivator)
    {
        parent::__construct();
        $this->eventDeactivator = $eventDeactivator;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modes:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate scheduled modes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now('Asia/Manila');
        $currentTimeWithoutSeconds = $currentTime->format('H:i');
        
        $scheduledModes = DB::table('mode_schedules')
            ->join('modes', 'mode_schedules.mode_id', '=', 'modes.id')
            ->select('mode_schedules.*')
            ->where('mode_schedules.end_time', '>=', $currentTimeWithoutSeconds)
            ->where('modes.is_active', true)
            ->get();
    
        foreach ($scheduledModes as $mode) {
            $endTimeWithoutSeconds = substr($mode->end_time, 0, 5);
            if(trim($endTimeWithoutSeconds)==$currentTimeWithoutSeconds){
                $this->eventDeactivator->deactivate($mode);
                echo "Deactivated mode with id: ".$mode->mode_id."\n";
            }
        }
    }
}