<?php

namespace JulesGraus\Housekeeper\Tests\Artifacts;

use Illuminate\Console\OutputStyle;
use JulesGraus\Housekeeper\Contracts\CanDoHouseKeeping;

class MyClass implements CanDoHouseKeeping
{
    public static function doHousekeeping(OutputStyle $output = null): void
    {
        $output->writeln('Doing some arbitrary housekeeping sample work');
    }
}
