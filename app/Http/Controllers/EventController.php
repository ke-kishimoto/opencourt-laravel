<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\EventUserCompanion;

// TODO-トランザクション

class EventController extends Controller
{
    
    public function search(Request $request)
    {
        $data = Event::orderByDesc('created_at')->get();
        return response($data, 200);
    }

    public function getEventByMonth($year, $month)
    {
        $events = Event::whereRaw('substring(event_date, 1, 4) = ?', [$year])
        ->whereRaw("substring(event_date, 6, 2) = ?", [$month])
        ->orderBy('event_date')
        ->orderBy('start_time')
        ->get();

        return response($events, 200);
    }

    public function get($id)
    {
        return response(Event::find($id), 200);
    }

    public function create(Request $request)
    {
        $result = Event::create([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'event_date' => substr($request->event_date, 0, 10),
            'start_time' => substr($request->start_time, 11, 5),
            'end_time' => substr($request->end_time, 11, 5),
            'place' => $request->place,
            'limit_number' => $request->limit_number,
            'description' => $request->description,
            'price1' => $request->price1,
            'price2' => $request->price2,
            'price3' => $request->price3,
            'price4' => $request->price4,
            'price5' => $request->price5,
        ]);

        return response($result, 200);
    }

    public function update(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $event->title = $request->title;
        $event->short_title = $request->short_title;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->place = $request->place;
        $event->limit_number = $request->limit_number;
        $event->description = $request->description;
        $event->price1 = $request->price1;
        $event->price2 = $request->price2;
        $event->price3 = $request->price3;
        $event->price4 = $request->price4;
        $event->price5 = $request->price5;
        $event->save();

        return response($event, 200);

    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        
        // TODO-transaction
        // 参加者と同伴者も削除
        EventUser::where('event_id', $event->id)->delete();
        EventUserCompanion::where('event_id', $event->id)->delete();
        
        $event->delete();

        return response([], 200);
    }
}
