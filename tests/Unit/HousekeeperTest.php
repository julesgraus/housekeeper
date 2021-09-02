<?php

namespace JulesGraus\Housekeeper\Tests\Unit;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use JulesGraus\Housekeeper\Housekeeper;
use JulesGraus\Housekeeper\Providers\HousekeeperProvider;
use JulesGraus\Housekeeper\Tests\Artifacts\InvalidMyClass;
use JulesGraus\Housekeeper\Tests\Artifacts\MyClass;
use JulesGraus\Housekeeper\Tests\TestCase;

class HousekeeperTest extends TestCase
{
    public function testInvalidRegistration() {
        $this->expectException(InvalidArgumentException::class);
        Housekeeper::register([InvalidMyClass::class]);
    }

    public function testValidRegistrationAndHousekeeping() {
        Housekeeper::register([MyClass::class]);

        Artisan::call('housekeeper:run');
        $output = Artisan::output();
        $this->assertStringContainsString('Housekeeping started.', $output);
        $this->assertStringContainsString('Housekeeping "MyClass"', $output);
        $this->assertStringContainsString('Housekeeping "MyClass" done', $output);
        $this->assertStringContainsString('Housekeeping done.', $output);
    }

    public function testInvalidTypedSchedulingCallback() {
        $this->expectException(InvalidArgumentException::class);
        Housekeeper::schedule(function($schedule) {});
    }

    public function testSchedulingCallback()
    {
        $housekeeperProvider = new HousekeeperProvider(app());
        $housekeeperProvider->boot();;

        Housekeeper::schedule(function (Event $schedule) {
            $schedule->twiceDaily(1, 13); //Run the task daily at 1:00 & 13:00
        });

        /** @var Schedule $scheduler */
        $scheduler = app(Schedule::class);
        $event = $scheduler->events()[0];
        $this->assertStringContainsString("'artisan' housekeeper:run", $event->getSummaryForDisplay());
        $this->assertStringContainsString("0 1,13 * * *", $event->getExpression());
    }
}
