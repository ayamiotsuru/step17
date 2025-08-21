<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //どのファイルを表示するかを指定
    public function test() {
        return view('test');
    }
}
