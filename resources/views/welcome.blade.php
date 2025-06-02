<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Tecsup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-xl shadow-xl max-w-md text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Logo" class="w-28 mx-auto mb-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenido a Tecsup</h1>
        <p class="text-gray-600 mb-6">Sistema Laravel + Oracle</p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Registrarse
            </a>
        </div>
    </div>

</body>
</html>
