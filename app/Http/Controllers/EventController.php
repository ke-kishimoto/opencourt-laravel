<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Event;

class EventController extends Controller
{
    public function list()
    {
        return view('eventList', ['title' => 'イベントリスト']);
    }

    public function regist()
    {
        return view('eventRegist', ['title' => 'イベント登録']);
    }

    public function getEventList(Request $request)
    {
        $data = Event::get();
        return response($data, 200);
    }

    public function show($id)
    {
        return view('eventDetail', 
            [
                'title' => 'イベント詳細',
                'id' => $id,
            ]
        );
    }

    public function get($id)
    {
        return response(Event::find($id), 200);
    }

    public function create(Request $request)
    {
        Event::create([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'place' => $request->place,
            'limit_number' => $request->limit_number,
            'detail' => $request->detail,
            'price1' => $request->price1,
            'price2' => $request->price2,
            'price3' => $request->price3,
        ]);

        return view('eventList', ['title' => 'イベント管理']);

    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->short_title = $request->short_title;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->place = $request->place;
        $event->limit_number = $request->limit_number;
        $event->detail = $request->detail;
        $event->price1 = $request->price1;
        $event->price2 = $request->price2;
        $event->price3 = $request->price3;
        $event->save();

        return view('eventList', ['title' => 'イベント管理']);

    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return view('eventList', ['title' => 'イベント管理']);

    }
}
