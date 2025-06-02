<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Lab11</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido </h1>
        <p class="text-gray-500 mb-6">Inicia sesión para continuar</p>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"
                class="w-full mb-4 px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required autofocus>

            <input type="password" name="password" placeholder="Contraseña"
                class="w-full mb-4 px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>

            <div class="flex justify-between text-sm text-gray-600 mb-4">
                <label>
                    <input type="checkbox" name="remember"> Recuérdame
                </label>
                <a href="{{ route('password.request') }}" class="text-indigo-500 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded transition">
                🔐 Iniciar sesión
            </button>
        </form>

        <p class="mt-6 text-sm text-gray-600">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}" class="text-green-500 font-semibold hover:underline">Regístrate aquí</a>
        </p>
    </div>

</body>
</html>
