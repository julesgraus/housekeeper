# housekeeper
Cleans up old stuff.

## Installation
You can install the package via composer:
```bash
composer require julesgraus/housekeeper
```
Make sure your root composer.json does contain a reference to the repository.
Make sure you've set up [a cron job on the server](https://laravel.com/docs/8.x/scheduling#running-the-scheduler) if you want to automatically trigger the housekeeper.

## Usage
Make sure your housekeepable classes will implement the ```CanDoHouseKeeping``` interface from this pacakge:

```php
class MyClass implements \JulesGraus\Housekeeper\Contracts\CanDoHouseKeeping {
    //Your regular methods and properties here.
    
    public static function doHousekeeping(OutputStyle $output) {
        //Put your houskeeping code here.
    }
}
```
You can use the ```$output``` variable to write feedback about the housekeeping to the console.
You can register your implementation to the housekeeper in a serviceprovider by passing it to the register method of the housekeeper:
```php
\JulesGraus\Housekeeper\Housekeeper::register([
    MyClass::class
]);
```

Every day at 02:00, the housekeeper will trigger the doHousekeeping methods af all registered classes by default.

### Running the housekeeper at a different time:
If you want to do run at a different time you can do so by using the housekeepers ```schedule``` command like so:
```php
\JulesGraus\Housekeeper\Housekeeper::schedule(function(\Illuminate\Console\Scheduling\Event $command) {
    $command->twiceDaily(1, 13); //Run the task daily at 1:00 & 13:00
});
```

### Manually running the housekeeper:
You can run ```php artisan housekeeper:run``` in your project root to manually run the housekeeper. This can be handy when testing.

## Testing
Run tests by running this command in the root of the package.

```bash
composer test
```
