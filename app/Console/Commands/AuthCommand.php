<?php

namespace App\Console\Commands;

use App\service\AuthService;
use Illuminate\Console\Command;

class AuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'to:auth {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Авторизация';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AuthService $authService)
    {
        print_r($authService($this->arguments()));
    }
}
