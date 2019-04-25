@extends('layouts.helloapp')

@section('title', 'ユーザー認証')

@section('menubar')
    @parent
    ユーザー認証ページ
@endsection

@section('content')
    <p>{{ $message }}</p>
    <table>
        <form action="/hello/auth" method="POST">
            {{ csrf_field() }}
            <tr>
                <th>name: </th>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <th>mail: </th>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" value="send"></td>
            </tr>
        </form>
    </table>
@endsection
