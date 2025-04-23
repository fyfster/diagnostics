<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LangController;
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

Route::post('car-list-dataTables/{userId?}', [CarController::class, 'listDataTables'])
    ->name('car-list-dataTables')
    ->middleware('permission:car-read');
Route::post('car-create/{userId?}', [CarController::class, 'create'])
    ->name('car-create')
    ->middleware('permission:car-create');
Route::post('car-edit', [CarController::class, 'edit'])
    ->name('car-edit')
    ->middleware('permission:car-edit');
Route::post('car-diagnostics', [CarController::class, 'diagnostics'])
    ->name('car-diagnostics')
    ->middleware('permission:car-read');
Route::get('car-list/{userId?}', [CarController::class, 'list'])
    ->name('car-list')
    ->middleware('permission:car-read');
Route::get('car-form/{carId?}', [CarController::class, 'form'])
    ->name('car-form')
    ->middleware('permission:car-create');
Route::get('car-delete/{carId}', [CarController::class, 'delete'])
    ->name('car-delete')
    ->middleware('permission:car-delete');

Route::post('user-list-dataTables', [UserController::class, 'listDataTables'])
    ->name('user-list-dataTables')
    ->middleware('permission:user-read');
Route::post('user-create', [UserController::class, 'create'])
    ->name('user-create')
    ->middleware('permission:user-create');
Route::post('user-edit', [UserController::class, 'edit'])
    ->name('user-edit')
    ->middleware('permission:user-edit');
Route::get('user-form/{userId?}', [UserController::class, 'form'])
    ->name('user-form')
    ->middleware('permission:user-edit');
Route::get('user-list', [UserController::class, 'list'])
    ->name('user-list')
    ->middleware('permission:user-read');
Route::get('user-delete/{userId}', [UserController::class, 'delete'])
    ->name('user-delete')
    ->middleware('permission:user-delete');

Route::get('race-list/{carId}', [RaceController::class, 'list'])->name('race-list');
Route::get('race-rename/{raceNr}', [RaceController::class, 'raceRename'])->name('race-rename');

Route::get('car-rpm-chart', [RaceController::class, 'rpmChart'])->name('car-rpm-chart');

Route::get('notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
Route::get('notifications-read', [NotificationController::class, 'markAsRead'])->name('notifications-read');
Route::get('notification-list', [NotificationController::class, 'getNotificationList'])->name('notification-list');
Route::get('notification-list-dataTables/{userId?}', [NotificationController::class, 'listDataTables'])->name('notification-list-dataTables');

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'loginSubmit'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/lang/{locale}', [LangController::class, 'lang'])->name('lang-switch');
