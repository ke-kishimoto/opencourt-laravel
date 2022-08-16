<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * @param int $id
     */
    public function get($id)
    {
        $news = News::find($id);
        return response($news, 200);
    }

    public function getAllNews()
    {
        $news = News::all();
        return response($news, 200);
    }

    public function getNewNews()
    {
        $news = News::orderByDesc('created_at')->first();
        return response($news, 200);
    }

    public function create(Request $request)
    {
        $news = News::create([
          'title' => $request->title,
          'content' => $request->content,
        ]);

        return response($news, 200);
    }

    public function delete($id)
    {
      $news = News::find($id);
      $news->delete();
      return response([], 200);
    }

}
