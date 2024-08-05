<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('car-list-dataTables/{userId?}', [CarController::class, 'listDataTables'])->name('car-list-dataTables');
Route::post('car-create/{userId?}', [CarController::class, 'create'])->name('car-create');
Route::post('car-edit', [CarController::class, 'edit'])->name('car-edit');
Route::post('car-diagnostics', [CarController::class, 'diagnostics'])->name('car-diagnostics');
Route::get('car-list/{userId?}', [CarController::class, 'list'])->name('car-list');
Route::get('car-form/{carId?}', [CarController::class, 'form'])->name('car-form');
Route::get('car-delete/{carId}', [CarController::class, 'delete'])->name('car-delete');

Route::post('user-list-dataTables', [UserController::class, 'listDataTables'])->name('user-list-dataTables');
Route::post('user-create', [UserController::class, 'create'])->name('user-create');
Route::post('user-edit', [UserController::class, 'edit'])->name('user-edit');
Route::get('user-form/{userId?}', [UserController::class, 'form'])->name('user-form');
Route::get('user-list', [UserController::class, 'list'])->name('user-list');
Route::get('user-delete/{userId}', [UserController::class, 'delete'])->name('user-delete');

Route::get('race-list/{carId}', [RaceController::class, 'list'])->name('race-list');
Route::get('race-rename/{raceNr}', [RaceController::class, 'raceRename'])->name('race-rename');

Route::get('car-rpm-chart', [RaceController::class, 'rpmChart'])->name('car-rpm-chart');

Route::get('notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
Route::get('notifications-read', [NotificationController::class, 'markAsRead'])->name('notifications-read');
Route::get('notification-list', [NotificationController::class, 'getNotificationList'])->name('notification-list');


Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'loginSubmit'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
