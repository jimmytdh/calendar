<?php

namespace App\Http\Controllers;

use App\Colors;
use App\Events;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function allEvents()
    {
        $events = Events::whereBetween('start_date',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
            ->orwhere('repeat_every','annual')
            ->get();
        $result = array();
        foreach($events as $e)
        {
            if($e->repeatEvery=='monthly'){
                $m = Carbon::parse($e->start_date)->format('m');
                $m = 12 - $m;

                for($i=0;$i<=$m;$i++){
                    $date = Carbon::parse($e->start_date)->addMonth($i);

                    if($date <= Carbon::parse($e->end_date)){
                        $start_date = Carbon::parse($date)->format("Y-m-d H:i:s");
                        $result[] = array(
                            'title' => $e->title,
                            'start' => $start_date,
                            'backgroundColor' => self::colors($e->color),
                            'borderColor' => self::colors($e->color)
                        );
                    }
                }
            }else if($e->repeatEvery=='annual'){
                $year = date('Y');
                $month = Carbon::parse($e->start_date)->format('m-d H:i:s');
                $date = "$year-$month";
                $result[] = array(
                    'title' => $e->title,
                    'start' => $date,
                    'allDay' => ($e->all_day==1) ? 'true':'false',
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }else{
                $result[] = array(
                    'title' => $e->title,
                    'start' => Carbon::parse($e->start_date)->format('Y-m-d H:i:s'),
                    'end' => Carbon::parse($e->end_date)->format('Y-m-d H:i:s'),
                    'allDay' => ($e->all_day==1) ? 'true':'false',
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }
        }

        return $result;
    }

    public function colors($color)
    {
        return Colors::where('color',$color)
            ->first()
            ->code;
    }
}
