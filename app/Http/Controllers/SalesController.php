<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function inputEventUserSales(Request $request)
    {
        foreach($request->eventUsers as $eventUser) {
            $eUser = EventUser::find($eventUser['id']);
            $eUser->attendance = $eventUser['attendance'];
            $eUser->amount = $eventUser['amount'];
            $eUser->amount_remark = $eventUser['amount_remark'];
            $eUser->save();
        }

        return response([], 200);
    }

    public function reflectEventDetail($eventId)
    {
        $eventTotal = EventUser::select(
          DB::raw(
            "sum(case 
                  when attendance = 'attendance' then 1
                  else 0
                end) as count_user
            , sum(case
                  when attendance = 'attendance' then ifnull(amount, 0)
                  else 0
                end) as amount_total"
          )
        )->where('event_id', $eventId)
        ->get();

        $event = Event::find($eventId);
        $event->number_of_user = $eventTotal->count_user;
        $event->number_of_user = $eventTotal->amount;
        $event->save();

        return response($event, 200);
    }
}
