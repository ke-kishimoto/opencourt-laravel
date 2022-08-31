<?php

namespace App\Http\Controllers;

use App\Models\EventUser;
use Illuminate\Http\Request;
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
}
