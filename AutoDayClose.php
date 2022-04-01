<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Auth;
use Log;
use App\SaleDay;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class AutoDayClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_day:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day close auto daily';

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
        $sale_days = SaleDay::latest()->first();
        Log::info('test command file');

        $latest_date = $sale_days->date;
        // $request = Request::create('/game/end/day/'.$latest_date, 'get');
        // '<a href=' . route('game.endday', $latest_date) . '></a>';
        // return $request;
        // return app()->make(HttpKernel::class)->handle($request);
        // return redirect()->to('game.endday', $latest_date);
        // return Route::get('game.endday', $latest_date);


        app()->make(HttpKernel::class)->handle(Request::create('/game/end/day/'.$latest_date,'GET',[$latest_date]));

        // $router = new Illuminate\Routing\Router(new Illuminate\Events\Dispatcher);

        // $request = Illuminate\Http\Request::create('game.endday', 'GET',$latest_date);

        // $router->dispatch($request);


    }
}
