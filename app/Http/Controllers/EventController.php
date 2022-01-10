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
            'short_title' => $request->shortTitle,
            'game_date' => $request->gameDate,
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
            'place' => $request->place,
            'limit_number' => $request->limitNumber,
            'detail' => $request->detail
        ]);
    }
}
