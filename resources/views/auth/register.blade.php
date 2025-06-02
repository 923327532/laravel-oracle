<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-400 via-blue-500 to-purple-600 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg p-10 w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Registrarse</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}"
                class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>

            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"
                class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>

            <input type="password" name="password" placeholder="Contraseña"
                class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>

            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                class="w-full p-3 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>

            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded shadow-md w-full">
                Crear Cuenta
            </button>
        </form>

        <p class="mt-6 text-sm text-gray-600">¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-indigo-500 font-semibold hover:underline">Inicia sesión aquí</a>
        </p>
    </div>

</body>
</html>
