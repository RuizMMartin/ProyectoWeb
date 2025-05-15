<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PedidoController;

// Route::get('/', function () {
 //return view('welcome');
//});

// Route::view('/', 'admins.login');

//vista princiapal
Route::view('/', 'index');
//vista de Acerca de nosotros
Route::view('/acercan', 'preview.acercan');
//vista de Contactanos
Route::view('/contact', 'preview.contact');
//vista de Team
Route::view('/team', 'preview.team');
//vista de FAQs
Route::view('/faq','preview.faq');
//vista de Termionos y condiciones
Route::view('/terms', 'preview.terms');

Route::view('/promotions', 'preview.promotions');

Route::view('/help', 'preview.help');

// //vista login
// Route::get('/loginAdmin', [AdministradoresController::class, 'login'])->name('login'); // Página de login si no está autenticado
// Route::post('/administradores/in', [AdministradoresController::class, 'in']); // Enviar formulario de login
// Route::middleware('auth:admins')->group(function(){
// //Sarai
// // Rutas de vista
// Route::view('/panel', 'plantilla.layoutAuth'); // Página principal del panel
// Route::view('/registro', 'admins.registro'); // Página de registro de administradores
// // Route::view('/lista', 'admins.lista'); // Página de lista de administradores
// Route::get('/lista', [AdministradoresController::class, 'lista']);


// // Rutas de autenticación
// //Route::post('/administradores/in', [AdministradoresController::class, 'in']); // Enviar formulario de login
// Route::post('/administradores/out', [AdministradoresController::class, 'out']); // Cerrar sesión (logout)
// //Route::get('/', [AdministradoresController::class, 'login'])->name('login'); // Página de login si no está autenticado

// //Sarai - Administradores 
// Route::get('/administradores/lista',[AdministradoresController::class,'lista']);
// Route::get('/administradores/registro',[AdministradoresController::class,'registro']);
// Route::post('/administradores/guardar',[AdministradoresController::class,'guardar']);
// Route::get('/administradores/{id}/editar',[AdministradoresController::class,'editar']);
// Route::post('/administradores/{id}/actualizar',[AdministradoresController::class,'actualizar']);
// Route::get('/administradores/{id}/mostrar',[AdministradoresController::class,'mostrar']);
// Route::post('/administradores/{id}/borrar',[AdministradoresController::class,'borrar']);
// });



//Rutas de CLIENTES
Route::get('/login', [ClientesController::class, 'login'])->name('login'); // Página de login si no está autenticado
Route::get('/clientes/in', [ClientesController::class, 'in']); // Enviar formulario de login
Route::post('/clientes/in', [ClientesController::class, 'in']);
Route::get('/registro', [ClientesController::class, 'registro'])->name('registro');
Route::post('/clientes/guardarRegistro', [ClientesController::class, 'guardarRegistro']);



Route::middleware('auth:clientes')->group(function(){

Route::view('/panel', 'plantilla.layout');


Route::get('/formularioClientes', [ClientesController::class, 'formularioClientes']);
Route::get('/listaClientes', [ClientesController::class, 'listaClientes']);
Route::post('/clientes/out', [ClientesController::class, 'out']);

Route::get('/perfil', [ClientesController::class,'perfil'])->name('perfil');
Route::get('/clientes/formularioClientes', [ClientesController::class,'formularioClientes']);
Route::post('/clientes/guardar', [ClientesController::class, 'guardar']);
Route::get('/clientes/{id}/editar', [ClientesController::class, 'editar']);
Route::post('/clientes/{id}/actualizar', [ClientesController::class, 'actualizar']);
Route::get('/clientes/{id}/mostrar', [ClientesController::class, 'mostrar']);
Route::post('/clientes/{id}/borrar', [ClientesController::class, 'borrar']);

});

//vistas de los productos
Route::view('/catalogoProductos','/productos/catalogoProductos');
Route::view('/registroProductos','/productos/registroProductos');
Route::view('/listaProductos','/productos/listaProductos');

//Controlador del CRUD de los productos
Route::get('/productos/registros', [ProductoController::class,'registros']);
Route::post('/productos/guardar', [ProductoController::class, 'guardar']);
Route::get('/productos/{id}/editar', [ProductoController::class, 'editar']);
Route::get('/productos/{id}/detalle', [ProductoController::class, 'detalle']);
Route::post('/productos/{id}/actualizar', [ProductoController::class, 'actualizar']);
Route::get('/productos/{id}/mostrar', [ProductoController::class, 'mostrar']);
Route::get('/catalogoProductos', [ProductoController::class, 'verProductos']);
Route::post('/productos/{id}/borrar', [ProductoController::class, 'borrar']);


//Rutas para carrito de compras
Route::view('cart','carrito/cart')->name('carrito');
//AgregarProductos
Route::post('cart/add',[CartController::class,'add'])->name('add');
//vistadeCheoutProductos
Route::get('cart/checkout',[CartController::class,'checkout'])->name('checkout');
//limpiarProductos
Route::get('cart/clear',[CartController::class,'clear'])->name('clear');
//removerProductos
Route::post('cart/removeItem',[CartController::class,'removeItem'])->name('removeItem');
//aumetarProductos
Route::post('/carrito/cantidad', [CartController::class, 'updateCantidad'])->name('updateCantidad');


//pedidos
Route::get('pedidos/listaPedidos',[CartController::class,'hacerPedido'])->name('hacerPedido');





//Martin - proveedores y productos.
Route::get('/listaProveedores', [ProveedorController::class, 'listaProveedores']);
Route::get('/registroProveedores', [ProveedorController::class, 'registroProveedores']);

Route::get('/proveedores/listaProveedores', [ProveedorController::class, 'listaProveedores']);
Route::get('/proveedores/registroProveedores', [ProveedorController::class, 'registroProveedores']);
Route::post('/proveedores/guardar', [ProveedorController::class, 'guardar']);
Route::get('/proveedores/{id}/mostrar', [ProveedorController::class, 'mostrar']);
Route::get('/proveedores/{id}/editar', [ProveedorController::class, 'editar']);
Route::put('/proveedores/{id}/actualizar', [ProveedorController::class, 'actualizar']);
Route::delete('/proveedores/{id}/borrar', [ProveedorController::class, 'borrar']);

//pago
Route::get('/paypal/checkout', [PayPalController::class, 'checkout'])->name('paypal.checkout');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');


//pedidos
Route::get('/hacerPedido',[PedidoController::class,'hacerPedido'])->name('hacerPedido');
Route::post('/finalizarPedido', [PedidoController::class, 'finalizarPedido'])->name('finalizarPedido');

//metodo paypal 
Route::get('/paypal', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');
