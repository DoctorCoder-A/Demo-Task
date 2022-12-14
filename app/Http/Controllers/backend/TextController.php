<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index()
    {
        \Log::info(123);
        $texts = Text::all();
        http_response_code(200);
        return response($texts);
    }
}
