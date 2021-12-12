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
}
