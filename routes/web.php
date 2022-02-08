<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClassController;

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

Route::get('/home', function () {
    return view('index');
})->name('homepage');

Route::get('/', function () {
    return view('index');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users')->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login_confirm'])->name('login_confirm');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register_confirm'])->name('register_confirm');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot_password');

Route::get('/admin/accounts', [AccountController::class, 'index'])->name('accounts');
Route::get('/admin/accounts/update/{account}', [AccountController::class, 'update'])->name('accounts.update');
Route::delete('/admin/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');

Route::get('/graph/class_grades_example', [ChartController::class, 'class_grades_example'])->name('graph.class_grades_example');
Route::post('/graph/class_grades/{class}', [ChartController::class, 'class_grades'])->name('graph.class_grades');

Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('auth');
Route::get('/admin/classes', [ClassController::class, 'admin_index'])->name('admin_classes')->middleware('auth'); 
Route::get('/admin/create_class', [ClassController::class, 'create'])->name('create_class')->middleware('auth'); 
Route::post('/admin/delete_class/{class}', [ClassController::class, 'delete'])->name('delete_class')->middleware('auth'); 
Route::post('/admin/search_classes', [ClassController::class, 'search_classes'])->name('search_classes')->middleware('auth'); 

Route::get('/classes/class_records/{class}', [ClassController::class, 'class_records'])->middleware('auth');
Route::post('/classes/class_records/{class}', [ClassController::class, 'class_records'])->name('classes.class_records')->middleware('auth');
Route::get('/classes/student_records/{student}', [ClassController::class, 'student_records'])->middleware('auth');
Route::post('/classes/student_records/{student}', [ClassController::class, 'student_records'])->name('classes.student_records')->middleware('auth');

Route::get('/admin/assignments/add_assignment/{class_id}', [AssignmentController::class, 'create'])->name('add_assignment')->middleware('auth');
Route::post('/admin/assignments/index/{class_id}', [AssignmentController::class, 'class_assignments'])->name('class_assignments')->middleware('auth');
Route::post('/admin/search_assignments', [AssignmentController::class, 'search_assignments'])->name('search_assignments')->middleware('auth');

Route::get('/students', [StudentController::class, 'index'])->name('students')->middleware('auth');