<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido al Dashboard</h2>

    <p>Hola, {{ Auth::user()->name }}. Has iniciado sesión correctamente.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
