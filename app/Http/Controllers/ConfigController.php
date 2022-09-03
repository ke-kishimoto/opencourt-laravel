<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{
    public function get()
    {
      $config = Config::get()->first();
      return response($config, 200);
    }

    public function update(Request $request)
    {
        $config = Config::get()->first();
        if(!$config) {
          $config = new Config();
        }
        $config->line_notify_flag = $request->line_notify_flag;
        $config->waiting_status_auto_update_flag = $request->waiting_status_auto_update_flag;
        $config->participant_border_number = $request->participant_border_number;
        $config->save();
        return response($config, 200);
    }
}
