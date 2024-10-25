<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="./img/favicon.png">
</head>
<body>
     {{ session()->forget('USER_INFO');}}
    <a href="{{ url('/auth/tumblr')}}">Iniciar sesion en tumblr</a>
</body>
</html>
