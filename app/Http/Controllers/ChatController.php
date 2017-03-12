<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Redis;
use Illuminate\Support\Facades\Redis;

// посмотреть пример с офф сайта, исправить ошибку на стороне laravel
class ChatController extends Controller {
    public function sendMessage(Request $request){
        $redis = Redis::connection();
        $data = ['message' => $request->input('message'), 'user' => $request->input('user')];
        $redis->publish( 'message', json_encode($data) );

        return response()->json([]);
    }
}
