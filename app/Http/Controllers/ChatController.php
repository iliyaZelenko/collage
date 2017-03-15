<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Redis;
use Illuminate\Support\Facades\Redis;
use Debugbar;

// посмотреть пример с офф сайта, исправить ошибку на стороне laravel
class ChatController extends Controller {
    public function sendMessage(Request $request){
        $redis = Redis::connection();
        $data = [
            'message' => $request->input('message'),
            'user' => $request->input('user')
        ];
        $publish = json_encode($data);

        Debugbar::info($publish);
        $redis->publish('message', $publish);

        return response($publish);
    }
}


