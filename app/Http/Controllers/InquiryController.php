<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    /**
     * @param int $id
     */
    public function get($id)
    {
        $news = Inquiry::find($id);
        return response($news, 200);
    }

    public function getAllInquiries()
    {
        $news = Inquiry::all();
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

        return response($inquiry, 200);
    }

    public function delete($id)
    {
      $news = Inquiry::find($id);
      $news->delete();
      return response([], 200);
    }

}
