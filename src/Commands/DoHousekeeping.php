<?php

namespace JulesGraus\Housekeeper\Commands;

use Illuminate\Console\Command;
use JulesGraus\Housekeeper\Housekeeper;

class DoHousekeeping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'housekeeper:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run housekeeping processes to clean up old stuff';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Housekeeper::doHouseKeeping($this->output);
        return 0;
    }
}
