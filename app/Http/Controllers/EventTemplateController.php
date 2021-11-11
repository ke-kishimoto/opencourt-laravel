<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventTemplate;

class EventTemplateController extends Controller
{
    public function index()
    {
        return view('eventTemplate', ['title' => 'イベントテンプレート']);
    }

    public function getList()
    {
        return response(EventTemplate::select('id', 'id as value', 'template_name as name')->get(), 200);
    }

    public function get($id)
    {
        return response(EventTemplate::find($id), 200);
    }

    public function delete($id)
    {
        $eventTemplate = EventTemplate::find($id);
        $result = $eventTemplate->delete();
        return response($result, 200);
    }

    public function create(Request $request)
    {
        if($request->isnew) {
            $eventTemplate = new EventTemplate();
        } else {
            $eventTemplate = EventTemplate::find($request->select_id);
        }
        $eventTemplate->template_name = $request->template_name;
        $eventTemplate->title = $request->title;
        $eventTemplate->short_title = $request->short_title;
        $eventTemplate->place = $request->place;
        $eventTemplate->limit_number = $request->limit_number;
        $eventTemplate->detail = $request->detail;
        $eventTemplate->price1 = $request->price1;
        $eventTemplate->price2 = $request->price2;
        $eventTemplate->price3 = $request->price3;
        $eventTemplate->price4 = $request->price4;
        $eventTemplate->price5 = $request->price5;
        $eventTemplate->save();
        return redirect()->route('eventTemplate');
    }
}
