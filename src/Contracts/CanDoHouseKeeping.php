<?php


namespace JulesGraus\Housekeeper\Contracts;


use Illuminate\Console\OutputStyle;

interface CanDoHouseKeeping
{
    /**
     * Clean up okd stuff
     */
    public static function doHousekeeping(OutputStyle $output = null): void;
}
