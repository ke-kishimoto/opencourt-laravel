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
        return redirect()->route('eventTemplate');
    }
}
