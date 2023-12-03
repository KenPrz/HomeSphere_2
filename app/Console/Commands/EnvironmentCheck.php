<?php

namespace App\Console\Commands;
use Carbon\Carbon;

use Illuminate\Console\Command;
use App\Http\Controllers\ModeEventActivator;
use Illuminate\Support\Facades\DB;

class EnvironmentCheck extends Command
{
    protected $modeEventActivator;
    public function __construct(ModeEventActivator $modeEventActivator)
    {
        parent::__construct();
        $this->modeEventActivator = $modeEventActivator;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modes:env_check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the environment mode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modesToCheck = DB::table('modes')
            ->where('is_active', false)
            ->where('activation_type', 'environment')
            ->get();
            if (count($modesToCheck) > 0) {
                foreach ($modesToCheck as $mode) {
                    $this->modeEventActivator->handleMode($mode->id);
                }
            }
    }
}
