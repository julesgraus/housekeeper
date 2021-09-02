<?php

namespace JulesGraus\Housekeeper\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use JulesGraus\Housekeeper\Commands\DoHousekeeping;

class HousekeeperProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            DoHousekeeping::class
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->scheduleHousekeeper();
    }

    private function scheduleHousekeeper() {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $scheduleEvent = $schedule->command('housekeeper:run');
            $scheduleCallback = app('schedulesHousekeeperUsing');

            if($scheduleCallback) {
                app('schedulesHousekeeperUsing')($scheduleEvent);
            } else {
                $schedule->command('housekeeper:run')->dailyAt('02:00');
            }
        });
    }
}
