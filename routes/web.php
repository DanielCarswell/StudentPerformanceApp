<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

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


Route::get('/admin/assignments/add_assignment/{class_id}', [AssignmentController::class, 'create'])->name('create_assignment')->middleware('auth');
Route::post('/admin/assignments/add_assignment', [AssignmentController::class, 'add'])->name('add_assignment')->middleware('auth');
Route::post('/admin/assignments/index/{class_id}', [AssignmentController::class, 'class_assignments'])->name('class_assignments')->middleware('auth');
Route::post('/admin/search_assignments', [AssignmentController::class, 'search_assignments'])->name('search_assignments')->middleware('auth');
Route::post('/admin/assignments/delete/{class_id}/{assignment_id}', [AssignmentController::class, 'delete'])->name('delete_assignment')->middleware('auth');
Route::delete('/admin/assignments/destroy/{assignment_id}', [AccountController::class, 'destroy'])->name('destroy_assignment')->middleware('auth');


Route::get('/admin/roles/add_role', [RoleController::class, 'create'])->name('add_role')->middleware('auth');
Route::get('/admin/roles/edit_role/{role}', [RoleController::class, 'edit'])->name('edit_role')->middleware('auth');
Route::get('/admin/roles/index', [RoleController::class, 'index'])->name('roles_index')->middleware('auth');
Route::post('/admin/search_roles', [RoleController::class, 'search_roles'])->name('search_roles')->middleware('auth');
Route::post('/admin/delete_role/{role}', [RoleController::class, 'delete'])->name('delete_role')->middleware('auth'); 
Route::post('/admin/roles/add_role_permission/{role}', [RoleController::class, 'add_role_permission'])->name('add_role_permission')->middleware('auth'); 

Route::get('/admin/permissions/index', [PermissionController::class, 'index'])->name('permission_index')->middleware('auth');
Route::post('/admin/permissions/role_permissions/{role}', [PermissionController::class, 'role_permissions'])->name('role_permissions')->middleware('auth');
Route::post('/admin/permissions/add_role_permission', [PermissionController::class, 'add_role_permission'])->name('add_permission')->middleware('auth'); 
Route::post('/admin/permissions/delete/{role_id}/{permission_id}', [PermissionController::class, 'delete'])->name('delete_role_permission')->middleware('auth'); 


Route::get('/students', [StudentController::class, 'index'])->name('students')->middleware('auth');