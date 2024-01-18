<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Маршруты для пользователей
Route::get('/register', [AuthController::class, 'userRegisterForm'])->name('user.register.form');
Route::post('/register', [AuthController::class, 'userRegister'])->name('user.register');
Route::get('/login', [AuthController::class, 'userLoginForm'])->name('user.login.form');
Route::post('/login', [AuthController::class, 'userLogin'])->name('user.login');

// Маршруты для авторизации администраторов
Route::get('/admin/register', [AuthController::class, 'adminRegisterForm'])->name('admin.register.form');
Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('admin.register');
Route::get('/admin/login', [AuthController::class, 'adminLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');

// Общий маршрут выхода
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/products/{id}', [IndexController::class, 'showProduct'])->name('product.show');

// Маршруты для  администраторов
Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('admin.products')->middleware('isAdmin');;
Route::get('/admin/products/create', [AdminController::class, 'createProductForm'])->name('admin.products.create')->middleware('isAdmin');
Route::post('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.store')->middleware('isAdmin');
Route::get('/admin/products/edit/{id}', [AdminController::class, 'editProductForm'])->name('admin.products.edit')->middleware('isAdmin');
Route::post('/admin/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update')->middleware('isAdmin');
Route::post('/admin/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete')->middleware('isAdmin');
Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.orders')->middleware('isAdmin');;
Route::delete('/admin/orders/delete/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete')->middleware('isAdmin');
Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users')->middleware('isAdmin');;
Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete')->middleware('isAdmin');

// Маршруты для  комментариев
Route::get('/products/{productId}/comments', [CommentController::class, 'showComments'])->name('comments.show');
Route::get('/products/{productId}/add-comment', [CommentController::class, 'showAddCommentForm'])->name('comments.showAddForm')->middleware('isUser');
Route::post('/products/{productId}/add-comment', [CommentController::class, 'addComment'])->name('comments.add')->middleware('isUser');
Route::post('/comments/{commentId}/delete', [CommentController::class, 'deleteComment'])->name('comments.delete')->middleware('isAdmin');

//Маршруты для заказов
Route::get('/orders/{userId}', [OrderController::class, 'showUserOrders'])->name('orders.showUserOrders')->middleware('isUser');
Route::post('/orders/add-to-cart/{productId}', [OrderController::class, 'addToCart'])->name('orders.addToCart')->middleware('isUser');
Route::post('/orders/{orderId}/updateQuantityPlus', [OrderController::class, 'updateQuantityPlus'])->name('orders.updateQuantityPlus')->middleware('isUser');
Route::post('/orders/{orderId}/updateQuantityMinus', [OrderController::class, 'updateQuantityMinus'])->name('orders.updateQuantityMinus')->middleware('isUser');
Route::post('/orders/{orderId}/update', [OrderController::class, 'updateOrderStatus'])->name('orders.updateStatus')->middleware('isUser');
Route::post('/orders/delete/{orderId}', [OrderController::class, 'deleteOrder'])->name('orders.delete')->middleware('isUser');

//Маршруты для сообщений
Route::get('/user/admins', [MessageController::class, 'showAdmins'])->name('admins.show')->middleware('isUser');
Route::get('/users/messages/{userId}', [MessageController::class, 'showUserMessages'])->name('users.messages')->middleware('isUser');
Route::get('/admins/messages/{adminId}', [MessageController::class, 'adminMessages'])->name('admins.messages')->middleware('isAdmin');;
Route::get('/admin/users/send-message/{userId}', [MessageController::class, 'showSendMessageForm'])->name('admin.showSendMessageForm')->middleware('isAdmin');
Route::post('/admin/users/send-message/{userId}', [MessageController::class, 'sendMessage'])->name('admin.sendMessage')->middleware('isAdmin');;
Route::get('/users/send-message-to-admin/{adminId}', [MessageController::class, 'showSendUserToAdminForm'])->name('user.showSendUserToAdminForm')->middleware('isUser');
Route::post('/users/send-message-to-admin/{adminId}', [MessageController::class, 'sendUserToAdminMessage'])->name('user.sendUserToAdminMessage')->middleware('isUser');
Route::delete('/users/messages/{userId}/delete/{messageId}', [MessageController::class, 'deleteUserMessage'])->name('user.deleteUserMessage')->middleware('isUser');
Route::delete('/admins/messages/{adminId}/delete/{messageId}', [MessageController::class, 'deleteAdminMessage'])->name('admin.deleteAdminMessage')->middleware('isAdmin');
