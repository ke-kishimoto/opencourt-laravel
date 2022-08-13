<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    public function get()
    {
      $config = PrivacyPolicy::get()->first();
      return response($config, 200);  
    }

    public function update(Request $request)
    {
      $result = PrivacyPolicy::get()->first();
      if(!$result) {
        $result = new PrivacyPolicy();
      }
      $result->content = $request->content;
      $result->save();
      return response($result, 200);
    }
}
