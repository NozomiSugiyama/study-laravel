<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelloRequest;
use Validator;

class HelloController extends Controller
{

    public function index(Request $request)
    {
        return view('hello.index', ['msg' => '正しく入力されました！']);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric|between:0,150',
        ]);
        if ($validator->fails()) {
            return redirect('hello')
                ->withErrors($validator)
                ->withInput();
        }
        return view('hello.index', ['msg' => '正しく入力されました！']);
    }
}
