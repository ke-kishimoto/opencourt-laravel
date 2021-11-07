<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{
    /**
     * @param int $id
     */
    public function show($id)
    {
        $config = Config::find($id);
        return view('config', [
            'title' => 'システム設定',
            'config' => $config,
            ]);
    }

    public function update(Request $request, $id)
    {
        $config = Config::find($id);
        $config->system_title = $request->system_title;
        $config->bg_color = $request->bg_color;
        $config->waiting_flg_auto_update = $request->waiting_flg_auto_update;
        $config->save();
        // return view('index', ['title' => 'カレンダー']);
        return redirect()->route('index');
    }
}
