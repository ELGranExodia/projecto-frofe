<?php

    // Importamos la clase Route
    use App\Core\Route;

    // Importamos la clase de nuestro controlador HomeController
    use App\Controllers\LoginController;
    use App\Controllers\DashboardController;
    use App\Controllers\ProveedorController;

    // Establecemos las rutas de nuestra aplicación
    Route::get('/', [LoginController::class, 'index']);
    Route::post('login/verify', [LoginController::class, 'verify']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/proveedores', [ProveedorController::class, 'index']);
    Route::post('proveedores/obtener_proveedores', [ProveedorController::class, 'obtener_proveedores']);
    Route::post('proveedores/guardar', [ProveedorController::class, 'guardar']);
    Route::post('proveedores/editar', [ProveedorController::class, 'editar']);
    Route::post('proveedores/eliminar', [ProveedorController::class, 'eliminar']);
    Route::post('proveedores/verificarNrc', [ProveedorController::class, 'verificarNrc']);
    Route::get('proveedores/informe', [ProveedorController::class, 'informe']);
    Route::get('proveedores/informetabla', [ProveedorController::class, 'informetabla']);


    // Ejecutamos el método para mapear nuestra ruta
    Route::dispatch();
