<?php

namespace App\Http\Controllers;

use App\SaleDay;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Log;
use App\Services\DaySaleService;


class SaleDayController extends Controller
{
    protected $daySaleService;
    public function __construct()
    { 
        $this->daySaleService=new DaySaleService;
    }
    public function index()
    {
        return view('sale_day.index');
    }
    public function endday($date)
    {
        
        // $date = \Artisan::call('auto_day:close');
        Log::info("command endday module in saledaycontroller");
        $new_Date=Carbon::create($date);
        $prev_sale_day=$this->daySaleService->endDay($date);
        
        $new_sale_day=$this->daySaleService->firstOrCreate($new_Date->addDays(1));
        $this->daySaleService->changeCurrentDay($new_sale_day->id);
        $this->daySaleService->shiftDayGameSales($new_sale_day->id,$prev_sale_day->id);
        Log::info("command endday module in saledaycontroller ENDDDDD");

        return redirect()->route('game.sale');
    }
    public function getSaleOfTheDate(Request $request)
    {
        $start_date=Carbon::create($request->year,$request->month+1,1);
        $end_date=Carbon::create($request->year,$request->month+1,1);
        $end_date->endOfMonth();
        $data=$this->daySaleService->getMonthSales($start_date,$end_date);
        return $data;
    }
    public function updateAdjustment(Request $request)
    {
        $saleDay=SaleDay::findorfail($request->sale_day_id);
        if($request->adjustment > $saleDay->sales){
            return 0;
        }else{
            $saleDay->adjustment=$request->adjustment;
            $saleDay->total_sale=$saleDay->sales-$request->adjustment;
            $saleDay->save();
            return 1;
        }
    }
    public function getMaxDay(Request $request)
    {
        return $this->daySaleService->getCurrentDay()->date;
    }
    public function getMaxDayDetails(Request $request)
    {
        $date=Carbon::create($this->daySaleService->getCurrentDay()->date);
        $data=[
            'date'=>$this->daySaleService->getCurrentDay()->date,
            'day'=>$date->day,
            'month'=>$date->month,
            'year'=>$date->year,
        ];
        return $data;
    }
}
