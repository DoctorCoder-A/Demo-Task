<?php

namespace App\service;

use App\Console\Commands\AuthCommand;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthService
{
    private $fiveMinutesToSecond = 300;
    public function __invoke(array $arguments): string
    {
        unset($arguments['command']);
        if(Auth::attempt($arguments)){
            $user = User::whereLogin($arguments['login'])->first();
            $data = [
                'token' => Str::random(64),
                'expires_at' => time() + $this->fiveMinutesToSecond,
                'user_id' => $user->id
            ];
            $tokenModel = Token::create($data);
            return $tokenModel->token;
        }
        return 'failed authentication!';
    }
}
