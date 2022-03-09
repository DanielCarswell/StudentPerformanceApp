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
use App\Http\Controllers\CSVUploadController;
use App\Http\Controllers\CircumstanceController;
use App\Http\Controllers\PDFController;

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
Route::get('/admin/accounts/edit/{account}', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/admin/accounts/update', [AccountController::class, 'update'])->name('account.update');
Route::delete('/admin/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');


Route::get('/graph/class_grades_example', [ChartController::class, 'class_grades_example'])->name('graph.class_grades_example');
Route::any('/graph/barchart/class_grades/{class}', [ChartController::class, 'class_grades'])->name('graph.class_grades');
Route::any('/graphs/pichart/ratings/{class}', [ChartController::class, 'class_ratings'])->name('graph.class_ratings');
Route::any('/graphs/student_details/{student}', [ChartController::class, 'student_details'])->name('graph.student_details');
Route::any('/graphs/student_ratings/{student}', [ChartController::class, 'student_ratings'])->name('graph.student_ratings');
Route::any('/graphs/select', [ChartController::class, 'select_graph'])->name('graph');


Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('auth');
Route::get('/admin/classes', [ClassController::class, 'admin_index'])->name('admin_classes')->middleware('auth');
Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('create_class')->middleware('auth'); 
Route::post('/admin/classes/delete/{class}', [ClassController::class, 'delete'])->name('delete_class')->middleware('auth'); 
Route::delete('/admin/classes/destroy/{class_id}', [ClassController::class, 'destroy'])->name('destroy_class')->middleware('auth'); 
Route::post('/admin/search_classes', [ClassController::class, 'search_classes'])->name('search_classes')->middleware('auth');
Route::any('/admin/class/students/{class}', [ClassController::class, 'students'])->name('class.students')->middleware('auth'); 
Route::any('/admin/class/students/add/{class}', [ClassController::class, 'add'])->name('class.students.add')->middleware('auth'); 
Route::any('/admin/class/students/add/{class_id}/{student_id}', [ClassController::class, 'add_student'])->name('class.add_student')->middleware('auth'); 
Route::delete('/admin/class/students/delete/{class_id}/{student_id}', [ClassController::class, 'delete_student'])->name('class.delete_student')->middleware('auth'); 
Route::post('/admin/class/assignments/{class}', [ClassController::class, 'assignments'])->name('class.assignments')->middleware('auth');
Route::any('/admin/classes/assignment_grades/{assignment}/{class}', [ClassController::class, 'assignment_grades'])->name('assignment_grades')->middleware('auth'); 
Route::get('/class/upload_students', [ClassController::class, 'upload_students'])->name('upload_students')->middleware('auth');

Route::get('/classes/class_records/{class}', [ClassController::class, 'class_records'])->middleware('auth');
Route::post('/classes/class_records/{class}', [ClassController::class, 'class_records'])->name('classes.class_records')->middleware('auth');
Route::get('/classes/student_records/{student}', [ClassController::class, 'student_records'])->middleware('auth');
Route::post('/classes/student_records/{student}', [ClassController::class, 'student_records'])->name('classes.student_records')->middleware('auth');


Route::get('/admin/assignments/add_assignment/{class_id}', [AssignmentController::class, 'create'])->name('create_assignment')->middleware('auth');
Route::post('/admin/assignments/add_assignment', [AssignmentController::class, 'add'])->name('add_assignment')->middleware('auth');
Route::post('/admin/assignments/edit/{assignment_id}/{class_id}', [AssignmentController::class, 'edit'])->name('edit_assignment')->middleware('auth');
Route::post('/admin/assignments/edit', [AssignmentController::class, 'modify'])->name('modify_assignment')->middleware('auth');
Route::post('/admin/assignments/index/{class_id}', [AssignmentController::class, 'class_assignments'])->name('class_assignments')->middleware('auth');
Route::post('/admin/search_assignments', [AssignmentController::class, 'search_assignments'])->name('search_assignments')->middleware('auth');
Route::post('/admin/assignments/delete/{class_id}/{assignment_id}', [AssignmentController::class, 'delete'])->name('delete_assignment')->middleware('auth');
Route::delete('/admin/assignments/destroy/{assignment_id}/{class_id}', [AssignmentController::class, 'destroy'])->name('destroy_assignment')->middleware('auth');
Route::get('/assignments/upload_marks', [AssignmentController::class, 'upload'])->name('upload_assignment_marks')->middleware('auth');
Route::post('/admin/assignments/update_mark', [AssignmentController::class, 'update_mark'])->name('update_assignment_mark')->middleware('auth');


Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('add_role')->middleware('auth');
Route::post('/admin/roles/edit_role/{role}', [RoleController::class, 'edit'])->name('edit_role')->middleware('auth');
Route::post('/admin/roles/edit', [RoleController::class, 'modify'])->name('modify_role')->middleware('auth');
Route::get('/admin/roles/index', [RoleController::class, 'index'])->name('roles_index')->middleware('auth');
Route::post('/admin/roles/add_role', [RoleController::class, 'add'])->name('create_role')->middleware('auth');
Route::post('/admin/search_roles', [RoleController::class, 'search_roles'])->name('search_roles')->middleware('auth');
Route::post('/admin/delete_role/{role}', [RoleController::class, 'delete'])->name('delete_role')->middleware('auth'); 
Route::post('/admin/roles/add_role_permission/{role}', [RoleController::class, 'add_role_permission'])->name('add_role_permission')->middleware('auth'); 


Route::get('/admin/permissions/index', [PermissionController::class, 'index'])->name('permission_index')->middleware('auth');
Route::post('/admin/permissions/role_permissions/{role}', [PermissionController::class, 'role_permissions'])->name('role_permissions')->middleware('auth');
Route::post('/admin/permissions/add_role_permission', [PermissionController::class, 'add_role_permission'])->name('add_permission')->middleware('auth'); 
Route::post('/admin/permissions/delete/{role_id}/{permission_id}', [PermissionController::class, 'delete'])->name('delete_role_permission')->middleware('auth'); 


Route::any('/admin/circumstances', [CircumstanceController::class, 'index'])->name('circumstances')->middleware('auth');
Route::any('/admin/circumstances/{circumstance}/links', [CircumstanceController::class, 'links'])->name('circumstance.links')->middleware('auth');
Route::delete('/admin/circumstances/links/destroy', [CircumstanceController::class, 'delete_link'])->name('circumstance.links.delete')->middleware('auth');
Route::post('/admin/circumstances/add_link', [CircumstanceController::class, 'add_link'])->name('circumstance.add_link')->middleware('auth');
Route::get('/admin/circumstances/add', [CircumstanceController::class, 'add'])->name('circumstance.add')->middleware('auth');
Route::post('/admin/circumstances/create', [CircumstanceController::class, 'create'])->name('circumstance.create')->middleware('auth');
Route::post('/admin/circumstances/edit/{circumstance}', [CircumstanceController::class, 'edit'])->name('circumstance.edit')->middleware('auth');
Route::post('/admin/circumstances/update', [CircumstanceController::class, 'update'])->name('circumstance.update')->middleware('auth');
Route::post('/admin/circumstances/delete/{circumstance}', [CircumstanceController::class, 'delete'])->name('circumstance.delete')->middleware('auth');
Route::delete('/admin/circumstances/destroy/{circumstance}', [CircumstanceController::class, 'destroy'])->name('circumstance.destroy')->middleware('auth');


Route::any('/students', [StudentController::class, 'index'])->name('students')->middleware('auth');
Route::any('/student/circumstance/add/{student}', [StudentController::class, 'add_circumstance'])->name('student.circumstance.add')->middleware('auth');
Route::post('/student/circumstance/update', [StudentController::class, 'update_circumstance'])->name('student.circumstance.update')->middleware('auth');
Route::delete('/student/circumstance/remove/{student_id}/{circumstance_id}', [StudentController::class, 'remove_circumstance'])->name('student.circumstance.remove')->middleware('auth');
Route::any('/student/circumstances/{student}', [StudentController::class, 'student_circumstances'])->name('student.circumstances')->middleware('auth');

Route::any('/assignment/upload_marks', [CSVUploadController::class, 'assignment_marks'])->name('file.upload.assignment');
Route::any('/assignment/upload_students', [CSVUploadController::class, 'upload_students'])->name('file.upload.students');

Route::get('/pdf/class_records/{class_id}', [PDFController::class, 'class_records'])->name('pdf.class_records');
Route::get('/pdf/student_records/{student_id}', [PDFController::class, 'student_records'])->name('pdf.student_records');