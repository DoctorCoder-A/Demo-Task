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
    public function editText(Request $request)
    {
        $data = $request->validate([
            'data' => 'required|array',
            'id' => 'required|int',
        ]);
        if(array_key_exists('text', $data['data'])){
            $text = Text::whereId($data['id'])
                ->first();
                $text->update([
                     'text' => $data['data']['text']
                ]);
            unset($text->{'name'});
            $text->{'element'} = 'text';
        }elseif (array_key_exists('name', $data['data'])){
            $text = Text::whereId($data['id'])->first();
                $text->update([
                    'name' => $data['data']['name']
                ]);
                unset($text->{'text'});
                $text->{'element'} = 'name';
        }
        http_response_code(200);
        return response($text);
    }
    public function deleteText(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|int'
        ]);

        $text = Text::whereId($data['id'])->delete();

        http_response_code(200);
        return response($text);
    }
}
