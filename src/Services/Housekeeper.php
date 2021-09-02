<?php


namespace JulesGraus\Housekeeper\Services;


use Closure;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\Scheduling\Event;
use InvalidArgumentException;
use JulesGraus\Housekeeper\Contracts\CanDoHouseKeeping;
use ReflectionFunction;

class Housekeeper
{
    /** @var CanDoHouseKeeping[] $housekeepables */
    private static array $housekeepables = [];

    /**
     * @param string[] $housekeepables
     */
    public static function register(array $housekeepables): void
    {
        self::$housekeepables = self::validateHousekeepables($housekeepables);
    }

    public static function doHouseKeeping(OutputStyle $output): void
    {
        $output->info('Housekeeping started.');

        foreach(self::$housekeepables as $housekeepable) {
            $output->writeln('Housekeeping "'.class_basename($housekeepable).'"');
            $housekeepable::doHousekeeping($output);
            $output->writeln('Housekeeping "'.class_basename($housekeepable).'" done');
        }
        $output->info('Housekeeping done.');
    }

    public static function validateHousekeepables(array $housekeepables): array
    {
        $validHousekeepables = array_filter($housekeepables, fn($housekeepable) => is_a($housekeepable, CanDoHouseKeeping::class, true));

        $invalidHousekeepables = array_diff($housekeepables, $validHousekeepables);
        if(count($invalidHousekeepables)) throw new InvalidArgumentException('The next classes are invalid housekeepables and should implement '.CanDoHouseKeeping::class.': '.implode(', ', $invalidHousekeepables));
        return $validHousekeepables;
    }

    /**
     * @throws \ReflectionException
     */
    public static function validateScheduleCallback(Closure $callback): void
    {
        $reflectionFunction = new ReflectionFunction($callback);
        $params = $reflectionFunction->getParameters();
        if(count($params) !== 1) throw new InvalidArgumentException('The schedule callback must have exactly 1 argument of type '.Event::class);
        if(!$params[0]->hasType()) throw new InvalidArgumentException('The first parameter of the schedule callback must have type '.Event::class);
    }
}
