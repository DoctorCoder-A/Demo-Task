<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Text;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $time_start = microtime(true);
        $data = $request->validate([
            'text' => 'required|string',
            'token' => 'required|string|size:64'
        ]);
        $tokenModel = DB::table('personal_access_tokens')
            ->where('is_actual', User::STATUS_ACTUAL)
            ->where('token', $data['token'])
            ->where('expires_at', '>', time())
            ->get();

        if(count($tokenModel)){
            $tokenModel = json_decode($tokenModel, true);
            $user_id = $tokenModel[0]['user_id'];
            Text::create([
                'name' => $data['token'],
                'text' => $data['text'],
                'user_id' => $user_id
            ]);
            $data['status'] =  1;
        }else{
            $data['status'] =  0;
        }
        $time_end = microtime(true);
        $data['working_time'] = ($time_end - $time_start);
        $data['memory'] =  memory_get_usage();
        http_response_code(200);
        return $data;
    }
}
