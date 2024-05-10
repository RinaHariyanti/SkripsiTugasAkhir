<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\PesticideController;
use App\Http\Controllers\ComparisonAlternatifController;

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
    return redirect()->route('login');
});

Route::get('/admin/history/rank', [ComparisonAlternatifController::class, 'userHistory'])->name('history');
Route::get('/user/history/rank', [ComparisonAlternatifController::class, 'userLatestHistory'])->name('history.latest');

Route::get('/compare/alternatives/{id}', [ComparisonAlternatifController::class, 'index'])->name('compare.alternatives');
Route::post('/compare/alternatives/show/{id}', [ComparisonAlternatifController::class, 'storeComparisonAlternatif'])->name('compare.storeComparisonAlternatif');

Route::get('/compare/criteria', [HomeController::class, 'index'])->name('compare.criteria');
Route::post('/compare/criteria', [HomeController::class, 'storeComparison'])->name('compare.storeComparison');
Route::get('/compare/criteria/{group_id}', [HomeController::class, 'show'])->name('compare.show');

Route::get('/compare/results/{group_id}', [ComparisonAlternatifController::class, 'rankResult'])->name('results.show');

Route::resource('pesticides', PesticideController::class)->names([
    'index' => 'pesticides.home',
    'create' => 'pesticides.create',
    'store' => 'pesticides.store',
    'show' => 'pesticides.show',
    // 'edit' => 'pesticides.edit',
    'update' => 'pesticides.update',
    'destroy' => 'pesticides.destroy',
]);

Route::resource('criteria', CriteriaController::class)->names([
    'index' => 'criteria.index',
    'create' => 'criteria.create',
    'store' => 'criteria.store',
    'show' => 'criteria.show',
    'edit' => 'criteria.edit',
    'update' => 'criteria.update',
    'destroy' => 'criteria.destroy',
]);

Route::get('/pesticides/{pesticide}/edit', [PesticideController::class, 'edit'])->name('pesticides.edit');


Route::get('/dashboard', [PesticideController::class, 'index'])->name('pesticides.dashboard');
Route::get('/manage-criteria', [CriteriaController::class, 'index'])->name('criteria.manage');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
