<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido {{$todo['usuario']}}!</h1>
    <p>Para ser parte de nuestro equipo solo da clic en el siguiente enlace.</p>  
    <a href="http://127.0.0.1:8000/api/validarCuenta/{{$todo['id']}}">VALIDAR CUENTA</a>
</body>
</html>