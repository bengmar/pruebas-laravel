<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\QueriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SignUpController;
use App\Http\Requests\QueriesRequest;
use Illuminate\Support\Facades\Route;


//Rutas de PrincipalController
Route::controller(MainController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/comercializacion', 'marketing')->name('marketing');
    Route::get('/terminos', 'terms')->name('terms');
    Route::get('/acerca-de', 'about')->name('about');
    Route::get('/contacto', 'contact')->name('contact');
    Route::get('/checkout', 'checkout')->name('checkout');
});

//Rutas de ProductController
Route::controller(ProductController::class)->group(function(){
    Route::get('/catalogo/{categoria?}', 'index')->name('catalog');
    Route::get('/producto-detalles/{id}', 'details')->name('product-details');
});


//Rutas de QueriesController
Route::get('/consultas', [QueriesController::class, 'create'])->name('queries');
Route::post('/enviar-consulta',[QueriesController::class, 'store']) ->name('queries.send');

//Rutas de SignUpController
Route::controller(SignUpController::class)->group(function(){
    Route::get('/signup', 'create')->name('signup.create');
    Route::post('/signup', 'store')->name('signup.store');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'authenticate')->name('login.authenticate');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::middleware(['auth'])->group(function () {

    // Ruta para el panel de usuario (Solo para Clientes, rol 2)
   // Route::get('/panel-usuario', [CustomerController::class, 'index'])
       // ->middleware(function ($request, $next) {
        //    if (auth()->user()->role_id !== 2) {
        //        return redirect('/admin'); // Si es admin, lo mandamos a su lugar
    //        }
//            return $next($request);
     //   })
     //   ->name('user.dashboard');

});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
}); /* Aseguro que 404 pase por el middleware web, asi se carga la sesión
y se visualiza si está logueado un usuario/admin */
