<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Event;

class EventController extends Controller
{
    
    public function getEventList(Request $request)
    {
        $data = Event::get();
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

    // public function update(Request $request, $id)
    // {
    //     $event = Event::findOrFail($id);
    //     $event->title = $request->title;
    //     $event->short_title = $request->short_title;
    //     $event->event_date = $request->event_date;
    //     $event->start_time = $request->start_time;
    //     $event->end_time = $request->end_time;
    //     $event->place = $request->place;
    //     $event->limit_number = $request->limit_number;
    //     $event->detail = $request->detail;
    //     $event->price1 = $request->price1;
    //     $event->price2 = $request->price2;
    //     $event->price3 = $request->price3;
    //     $event->save();

    //     return view('eventList', ['title' => 'イベント管理']);

    // }

    // public function delete($id)
    // {
    //     $event = Event::findOrFail($id);
    //     $event->delete();

    //     return view('eventList', ['title' => 'イベント管理']);

    // }
}
