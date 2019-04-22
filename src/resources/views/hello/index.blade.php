<html>
<head>
<title>Hello</title>
<style>
body { font-size: 16pt; color: #999; }
h1 { font-size: 100pt; text-align: right; color: #eee;
    margin: -40px 0px -50px 0px; }
</style>
</head>
<body>
    @isset ($msg)
    <p>こんにちは {{$msg}}さん。</p>
    @else
    <p>なにか書いて下さい。</p>
    @endisset
    <form method="POST" action="/hello">
        {{ csrf_field() }}
        <input type="text" name="msg">
        <input type="submit">
    </form>
</body>
</html>