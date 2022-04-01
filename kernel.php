<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Events\RssFeedUpdateEvent;
use App\Store;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
//        'App\Console\Commands\AutoDayClose'
        Commands\AutoDayClose::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        foreach (['11:00', '13:00', '19:00', '23:00'] as $time) {
            $schedule->call(function () {
                RssFeedUpdateEvent::dispatch();
            })->dailyAt($time)->timezone('GMT-5');
            // })->dailyAt($time)->timezone('America/Texas');;
        }
        // $schedule->call(function () {
        //     RssFeedUpdateEvent::dispatch();
        // })->dailyAt('13:25');
        // $schedule->call(function () {
        //     RssFeedUpdateEvent::dispatch();
        // })->dailyAt('13:45')->timezone('Asia/Karachi');;

//        $auto_day_time = Store::all()->get();
//        dd($auto_day_time);
        $schedule->command('auto_day:close')
            ->everyFiveMinutes()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
