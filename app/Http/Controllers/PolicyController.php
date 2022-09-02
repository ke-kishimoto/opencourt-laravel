<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{
    public function get($type)
    {
      $policy = Policy::where('policy_type', $type)->first();
      return response($policy, 200);  
    }

    public function update(Request $request)
    {
      $result = Policy::where('policy_type', $request->policy_type)->first();
      if(!$result) {
        $result = new Policy();
      }
      $result->policy_type = $request->policy_type;
      $result->content = $request->content;
      $result->save();
      return response($result, 200);
    }
}
