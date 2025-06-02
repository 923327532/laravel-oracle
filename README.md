Tarea- Aplicación Laravel + Oracle con Procedimiento Almacenado

🚀 Descripción General

Esta aplicación Laravel permite demostrar la integración entre Laravel (PHP) y Oracle Database. Desarrollada para el Laboratorio 11, implementa un flujo completo desde el inicio de sesión hasta la ejecución de un procedimiento almacenado. El sistema permite ingresar usuarios, visualizar registros y sincronizar dos tablas mediante la sentencia MERGE ejecutada directamente desde Laravel.

📂 Tecnologías utilizadas

Framework: Laravel 9

Lenguaje: PHP 8.1

Base de Datos: Oracle Database 21c Express Edition (XE)

ORM: Eloquent (Laravel)

Paquete conexión Oracle: yajra/laravel-oci8

Estilos: Tailwind CSS, FontAwesome

Frontend: Blade Templates

⚙️ Instalación paso a paso

1. Requisitos previos

Tener PHP 8.1 instalado correctamente

Composer

Oracle XE corriendo y accesible (usuario con privilegios)

Instalar InstantClient y habilitar ext-oci8 en PHP (confirmar en php.ini)

2. Crear el proyecto Laravel

composer create-project laravel/laravel:^9.0 Lab11
cd Lab11
composer require yajra/laravel-oci8:"^9.0"

3. Instalar Breeze (login y registro)

composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate

4. Configurar la conexión a Oracle en .env

DB_CONNECTION=oracle
DB_HOST=127.0.0.1
DB_PORT=1521
DB_DATABASE=XE
DB_USERNAME=system
DB_PASSWORD=Lopez2003

🔧 Diseño del sistema

Tablas en Oracle

CREATE TABLE tabla_origen (
id NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
nombre VARCHAR2(100),
email VARCHAR2(100) UNIQUE,
telefono VARCHAR2(20),
direccion VARCHAR2(200),
fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tabla_destino (
id NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
nombre VARCHAR2(100),
email VARCHAR2(100) UNIQUE,
telefono VARCHAR2(20),
direccion VARCHAR2(200),
fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Procedimiento almacenado en Oracle

CREATE OR REPLACE PROCEDURE actualizar_tabla_destino AS
BEGIN
MERGE INTO tabla_destino d
USING tabla_origen o ON (d.email = o.email)
WHEN MATCHED THEN
UPDATE SET
d.nombre = o.nombre,
d.telefono = o.telefono,
d.direccion = o.direccion,
d.fecha_creacion = CURRENT_TIMESTAMP
WHEN NOT MATCHED THEN
INSERT (id, nombre, email, telefono, direccion, fecha_creacion)
VALUES (tabla_destino_seq.NEXTVAL, o.nombre, o.email, o.telefono, o.direccion, CURRENT_TIMESTAMP);
COMMIT;
END;

🧠 Lógica en Laravel

Modelo

// app/Models/TablaOrigen.php
class TablaOrigen extends Model {
protected $table = 'tabla_origen';
protected $fillable = ['nombre', 'email', 'telefono', 'direccion', 'fecha_creacion'];
public $timestamps = false;
}

Controlador

// app/Http/Controllers/TablaOrigenController.php
public function actualizar() {
try {
DB::connection()->getPdo()->exec("BEGIN actualizar_tabla_destino; END;");
return back()->with('success', 'Tabla destino actualizada correctamente.');
} catch (\Exception $e) {
return back()->with('error', 'Error: ' . $e->getMessage());
}
}

Rutas

Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', [TablaOrigenController::class, 'vistaDashboard'])->name('dashboard');
Route::post('/actualizar-tabla', [TablaOrigenController::class, 'actualizar'])->name('actualizar.tabla');
});

Vista dashboard.blade.php

Contiene el botón de sincronización, los mensajes de estado, y muestra registros recientes de ambas tablas.

📋 Flujo de funcionamiento

El usuario accede a la aplicación y se registra o inicia sesión.

Se le redirige al dashboard.

Visualiza los registros recientes de ambas tablas.

Al presionar el botón "Ejecutar Procedimiento", Laravel llama al procedimiento PL/SQL actualizar_tabla_destino.

Este realiza un MERGE actualizando e insertando según los correos.

Laravel muestra un mensaje de éxito y actualiza la visualización.

📸 Capturas necesarias para el informe

Bienvenida (welcome.blade.php)

Registro (register.blade.php)

Login (login.blade.php)

Dashboard antes y después de ejecutar el procedimiento

Vista de comparación entre tabla_origen y tabla_destino

Mensaje de éxito de actualización

Consola SQL con SELECT COUNT(\*) FROM tabla_destino;

🧪 Datos para prueba

INSERT INTO tabla_origen (nombre, email, telefono, direccion)
VALUES ('Carlos Pérez', 'cperez@example.com', '987654321', 'Av. Perú 123');
COMMIT;

Luego ejecutar desde Laravel o desde SQL:

BEGIN actualizar_tabla_destino; END;

🧑‍💻 Autor

Roberto Carlos López Calle
Estudiante - TECSUP

Proyecto académico desarrollado para el curso de Base de Datos Avanzadas. Esta aplicación demuestra la integración Laravel + Oracle y el uso de procedimientos almacenados desde el backend PHP.
