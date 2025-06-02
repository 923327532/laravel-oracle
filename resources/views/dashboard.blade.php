<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lab11</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 min-h-screen flex flex-col items-center px-4 py-8">

    {{-- Tarjeta principal --}}
    <div class="bg-white max-w-6xl w-full rounded-3xl shadow-2xl overflow-hidden transform transition duration-500 hover:scale-[1.01] mb-8">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Hola, {{ Auth::user()->name }} 👋</h1>
                    <p class="mt-1 text-sm text-white/80">Panel de control de <strong>Lab11</strong> | Laravel + Oracle</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded-full transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- Cuerpo --}}
        <div class="p-8">

            {{-- Mensajes --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow animate-fade-in flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                    @if(session('registros_count'))
                    <p class="text-sm mt-1">{{ session('registros_count') }} registros fueron actualizados</p>
                    @endif
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow animate-fade-in flex items-start">
                <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            {{-- Panel de acción --}}
            <div class="bg-indigo-50 rounded-xl p-6 mb-8 border border-indigo-100">
                <h2 class="text-xl font-bold text-indigo-800 mb-4 flex items-center">
                    <i class="fas fa-database mr-2"></i> Sincronización de datos
                </h2>
                <p class="text-gray-600 mb-6">
                    Ejecuta el procedimiento almacenado para sincronizar <strong>tabla_destino</strong> con los últimos cambios de <strong>tabla_origen</strong>.
                </p>
                <form method="POST" action="{{ route('actualizar.tabla') }}" id="form-actualizar">
                    @csrf
                    <button id="btn-actualizar" type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2 mx-auto">
                        <i id="spinner" class="fas fa-sync-alt hidden animate-spin"></i>
                        <span id="btn-texto">Ejecutar Procedimiento</span>
                    </button>
                </form>
            </div>

            {{-- Comparación de tablas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                {{-- Tabla Origen --}}
                <div class="bg-white rounded-lg shadow overflow-hidden border border-indigo-200">
                    <div class="bg-indigo-100 p-3 flex items-center">
                        <i class="fas fa-table mr-2 text-indigo-600"></i>
                        <h3 class="font-bold text-indigo-800">Tabla Origen (Últimos 5)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th class="p-2 text-left">ID</th>
                                    <th class="p-2 text-left">Nombre</th>
                                    <th class="p-2 text-left">Email</th>
                                    <th class="p-2 text-left">Teléfono</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($origen ?? [] as $o)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2">{{ $o->id }}</td>
                                    <td class="p-2">{{ $o->nombre }}</td>
                                    <td class="p-2">{{ $o->email }}</td>
                                    <td class="p-2">{{ $o->telefono }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tabla Destino --}}
                <div class="bg-white rounded-lg shadow overflow-hidden border border-purple-200">
                    <div class="bg-purple-100 p-3 flex items-center">
                        <i class="fas fa-table mr-2 text-purple-600"></i>
                        <h3 class="font-bold text-purple-800">Tabla Destino (Últimos 5)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-purple-50">
                                <tr>
                                    <th class="p-2 text-left">ID</th>
                                    <th class="p-2 text-left">Nombre</th>
                                    <th class="p-2 text-left">Email</th>
                                    <th class="p-2 text-left">Teléfono</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($destino ?? [] as $d)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2">{{ $d->id }}</td>
                                    <td class="p-2">{{ $d->nombre }}</td>
                                    <td class="p-2">{{ $d->email }}</td>
                                    <td class="p-2">{{ $d->telefono }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Registros actualizados --}}
            @if(session('registros') && count(session('registros')) > 0)
            <div class="mt-8">
                <div class="bg-pink-100 p-3 rounded-t-lg flex items-center">
                    <i class="fas fa-history mr-2 text-pink-600"></i>
                    <h3 class="font-bold text-pink-800">Registros Recientemente Actualizados</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm bg-white rounded-b-lg shadow">
                        <thead class="bg-pink-50">
                            <tr>
                                <th class="p-2 text-left">ID</th>
                                <th class="p-2 text-left">Nombre</th>
                                <th class="p-2 text-left">Email</th>
                                <th class="p-2 text-left">Actualizado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach(session('registros') as $r)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2">{{ $r->id }}</td>
                                <td class="p-2">{{ $r->nombre }}</td>
                                <td class="p-2">{{ $r->email }}</td>
                                <td class="p-2 text-xs text-gray-500">{{ \Carbon\Carbon::parse($r->fecha_creacion)->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Botón para vaciar la tabla --}}
    <form method="POST" action="{{ route('reset.destino') }}" class="mt-10 text-center">
        @csrf
        <button type="submit"
            class="bg-red-100 text-red-700 font-semibold px-6 py-2 rounded-full hover:bg-red-200 transition duration-300 shadow">
            🧼 Vaciar tabla_destino
        </button>
    </form>


    {{-- Scripts --}}
    <script>
        const form = document.getElementById('form-actualizar');
        const btn = document.getElementById('btn-actualizar');
        const spinner = document.getElementById('spinner');
        const texto = document.getElementById('btn-texto');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            spinner.classList.remove('hidden');
            texto.textContent = 'Sincronizando...';
        });
    </script>

    {{-- Estilos --}}
    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</body>

</html>