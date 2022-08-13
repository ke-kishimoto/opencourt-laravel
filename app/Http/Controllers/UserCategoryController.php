<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class UserCategoryController extends Controller
{

    public function all()
    {
      $result = UserCategory::all();
      return response($result, 200);
    }

    public function updateAll(Request $request)
    {
      foreach($request->categories as $category) {
        if(isset($category["id"])) {
          $model = UserCategory::find($category["id"]);
          $model->category_name = $category["category_name"] ?? '';
          $model->save();
        } else {
          if(isset($category["category_name"])) {
            $model = new UserCategory();
            $model->category_name = $category["category_name"] ?? '';
            $model->save();
          }
        }
      }
      return response([], 200);
    }
}
