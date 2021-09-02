<?php


namespace JulesGraus\Housekeeper;


use Closure;
use Illuminate\Console\OutputStyle;
use JulesGraus\Housekeeper\Services\Housekeeper as HousekeeperService;

/**
 * Provides an interface to the rest of the application
 */
class Housekeeper
{
    public static function register(array $housekeepables) {
        HousekeeperService::register($housekeepables);
    }

    public static function doHouseKeeping(OutputStyle $output = null) {
        HousekeeperService::doHouseKeeping($output);
    }

    public static function schedule(Closure $closure) {
        HousekeeperService::validateScheduleCallback($closure);
        app()->bind('schedulesHousekeeperUsing', fn() => $closure);
    }
}
