<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Services\LineNotifyService;

class InquiryController extends Controller
{
    private $lineNotifyService;

    public function __construct(LineNotifyService $lineNotify)
    {
        $this->lineNotifyService = $lineNotify;
    }

    /**
     * @param int $id
     */
    public function get($id)
    {
        $news = Inquiry::with('user')->with('event')->find($id);
        return response($news, 200);
    }

    public function all()
    {
        $news = Inquiry::with('user')->with('event')->get();
        return response($news, 200);
    }

    public function create(Request $request)
    {
        $inquiry = Inquiry::create([
          'event_id' => $request->event_id,
          'user_id' => $request->user()->id,
          'title' => $request->title,
          'content' => $request->content,
          'status' => 'yet',
        ]);

        $this->lineNotifyService->inquiry($inquiry);

        return response($inquiry, 200);
    }

    public function updateStatus(Request $request)
    {
        $inquiry = Inquiry::find($request->id);
        if($inquiry->status === 'yet') {
          $inquiry->status = 'done';
        } else {
          $inquiry->status = 'yet';
        }
        $inquiry->save();

        return response($inquiry, 200);
    }

    public function delete($id)
    {
      $news = Inquiry::find($id);
      $news->delete();
      return response([], 200);
    }

}
