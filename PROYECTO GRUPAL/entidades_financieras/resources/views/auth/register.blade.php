<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>