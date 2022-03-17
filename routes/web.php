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
})->name('/home');

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

Route::get('/admin/accounts', [AccountController::class, 'index'])->name('accounts')->middleware('admin');
Route::get('/admin/accounts/edit/{account}', [AccountController::class, 'edit'])->name('account.edit')->middleware('admin');
Route::post('/admin/accounts/update', [AccountController::class, 'update'])->name('account.update')->middleware('admin');
Route::delete('/admin/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy')->middleware('admin');
Route::get('/admin/accounts/create_students', [AccountController::class, 'student_accounts'])->name('create_student_accounts')->middleware('admin');

Route::any('/graphs/barchart/class_grades/{class}', [ChartController::class, 'class_grades'])->name('graph.class_grades')->middleware('staff');
Route::any('/graphs/pichart/ratings/{class}', [ChartController::class, 'class_ratings'])->name('graph.class_ratings')->middleware('staff');
Route::any('/graphs/student_details/{student}', [ChartController::class, 'student_details'])->name('graph.student_details')->middleware('auth');
Route::any('/graphs/student_ratings/{student}', [ChartController::class, 'student_ratings'])->name('graph.student_ratings')->middleware('auth');
Route::any('/graphs/select', [ChartController::class, 'select_graph'])->name('graph');

Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('auth');
Route::get('/admin/classes', [ClassController::class, 'admin_index'])->name('admin_classes')->middleware('staff');
Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('create_class')->middleware('staff'); 
Route::post('/admin/create/class', [ClassController::class, 'create_class'])->name('class.create')->middleware('staff'); 
Route::get('/create/class', [ClassController::class, 'create_lecturer'])->name('class.lecturer.create')->middleware('staff'); 
Route::post('/lecturer/create/class', [ClassController::class, 'lecturer_create'])->name('class.lecturer_create')->middleware('staff'); 
Route::post('/admin/classes/delete/{class}', [ClassController::class, 'delete'])->name('delete_class')->middleware('staff'); 
Route::delete('/admin/classes/destroy/{class_id}', [ClassController::class, 'destroy'])->name('destroy_class')->middleware('admin'); 
Route::post('/admin/search_classes', [ClassController::class, 'search_classes'])->name('search_classes')->middleware('staff');
Route::any('/admin/class/students/{class}', [ClassController::class, 'students'])->name('class.students')->middleware('staff'); 
Route::any('/admin/class/students/add/{class}', [ClassController::class, 'add'])->name('class.students.add')->middleware('staff'); 
Route::any('/admin/class/students/add/{class_id}/{student_id}', [ClassController::class, 'add_student'])->name('class.add_student')->middleware('staff'); 
Route::delete('/admin/class/students/delete/{class_id}/{student_id}', [ClassController::class, 'delete_student'])->name('class.delete_student')->middleware('staff'); 
Route::post('/class/assignments/{class}', [ClassController::class, 'assignments'])->name('class.assignments')->middleware('staff');
Route::any('/admin/classes/assignment_grades/{assignment}/{class}', [ClassController::class, 'assignment_grades'])->name('assignment_grades')->middleware('staff'); 
Route::get('/class/upload_students', [ClassController::class, 'upload_students'])->name('upload_students')->middleware('staff');
Route::any('/classes/class_records/{class}', [ClassController::class, 'class_records'])->name('classes.class_records')->middleware('staff');
Route::get('/classes/student_records/{student}', [ClassController::class, 'student_records'])->middleware('auth');
Route::post('/classes/student_records/{student}', [ClassController::class, 'student_records'])->name('classes.student_records')->middleware('auth');
Route::get('/classes/upload_attendance', [ClassController::class, 'upload_attendance'])->name('upload_attendance')->middleware('staff');
Route::post('/classes/update_attendance', [ClassController::class, 'update_attendance'])->name('update_attendance')->middleware('staff');
Route::any('/admin/classes/attendance/{class}', [ClassController::class, 'class_attendance'])->name('class_attendance')->middleware('staff'); 


Route::get('/admin/assignments/add_assignment/{class_id}', [AssignmentController::class, 'create'])->name('create_assignment')->middleware('staff');
Route::post('/admin/assignments/add_assignment', [AssignmentController::class, 'add'])->name('add_assignment')->middleware('staff');
Route::post('/admin/assignments/edit/{assignment_id}/{class_id}', [AssignmentController::class, 'edit'])->name('edit_assignment')->middleware('staff');
Route::post('/admin/assignments/edit', [AssignmentController::class, 'modify'])->name('modify_assignment')->middleware('staff');
Route::post('/admin/assignments/index/{class_id}', [AssignmentController::class, 'class_assignments'])->name('class_assignments')->middleware('staff');
Route::post('/admin/search_assignments', [AssignmentController::class, 'search_assignments'])->name('search_assignments')->middleware('staff');
Route::post('/admin/assignments/delete/{class_id}/{assignment_id}', [AssignmentController::class, 'delete'])->name('delete_assignment')->middleware('staff');
Route::delete('/admin/assignments/destroy/{assignment_id}/{class_id}', [AssignmentController::class, 'destroy'])->name('destroy_assignment')->middleware('staff');
Route::get('/assignments/upload_marks', [AssignmentController::class, 'upload'])->name('upload_assignment_marks')->middleware('staff');
Route::post('/admin/assignments/update_mark', [AssignmentController::class, 'update_mark'])->name('update_assignment_mark')->middleware('staff');

Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('add_role')->middleware('admin');
Route::post('/admin/roles/edit_role/{role}', [RoleController::class, 'edit'])->name('edit_role')->middleware('admin');
Route::post('/admin/roles/edit', [RoleController::class, 'modify'])->name('modify_role')->middleware('admin');
Route::get('/admin/roles/index', [RoleController::class, 'index'])->name('roles_index')->middleware('admin');
Route::any('/admin/user/roles/index/{user_id}', [RoleController::class, 'user_roles'])->name('user_roles')->middleware('admin');
Route::post('/admin/roles/add_role', [RoleController::class, 'add'])->name('create_role')->middleware('admin');
Route::get('/admin/user/roles/add/{user}', [RoleController::class, 'give'])->name('give_role')->middleware('admin');
Route::post('/admin/user/roles/add', [RoleController::class, 'give_role'])->name('give_user_role')->middleware('admin');
Route::post('/admin/search_roles', [RoleController::class, 'search_roles'])->name('search_roles')->middleware('admin');
Route::post('/admin/delete_role/{role}', [RoleController::class, 'delete'])->name('delete_role')->middleware('admin'); 
Route::post('/admin/user/remove_role', [RoleController::class, 'remove'])->name('remove_role')->middleware('admin'); 
Route::post('/admin/roles/add_role_permission/{role}', [RoleController::class, 'add_role_permission'])->name('add_role_permission')->middleware('admin'); 

Route::get('/admin/permissions/index', [PermissionController::class, 'index'])->name('permission_index')->middleware('admin');
Route::post('/admin/permissions/role_permissions/{role}', [PermissionController::class, 'role_permissions'])->name('role_permissions')->middleware('admin');
Route::post('/admin/permissions/add_role_permission', [PermissionController::class, 'add_role_permission'])->name('add_permission')->middleware('admin'); 
Route::post('/admin/permissions/delete/{role_id}/{permission_id}', [PermissionController::class, 'delete'])->name('delete_role_permission')->middleware('admin'); 

Route::any('/admin/circumstances', [CircumstanceController::class, 'index'])->name('circumstances')->middleware('staff');
Route::any('/admin/circumstances/{circumstance}/links', [CircumstanceController::class, 'links'])->name('circumstance.links')->middleware('staff');
Route::delete('/admin/circumstances/links/destroy', [CircumstanceController::class, 'delete_link'])->name('circumstance.links.delete')->middleware('staff');
Route::post('/admin/circumstances/add_link', [CircumstanceController::class, 'add_link'])->name('circumstance.add_link')->middleware('staff');
Route::get('/admin/circumstances/add', [CircumstanceController::class, 'add'])->name('circumstance.add')->middleware('staff');
Route::post('/admin/circumstances/create', [CircumstanceController::class, 'create'])->name('circumstance.create')->middleware('staff');
Route::post('/admin/circumstances/edit/{circumstance}', [CircumstanceController::class, 'edit'])->name('circumstance.edit')->middleware('staff');
Route::post('/admin/circumstances/update', [CircumstanceController::class, 'update'])->name('circumstance.update')->middleware('staff');
Route::post('/admin/circumstances/delete/{circumstance}', [CircumstanceController::class, 'delete'])->name('circumstance.delete')->middleware('staff');
Route::delete('/admin/circumstances/destroy/{circumstance}', [CircumstanceController::class, 'destroy'])->name('circumstance.destroy')->middleware('staff');

Route::any('/students', [StudentController::class, 'index'])->name('students')->middleware('staff');
Route::any('/student/circumstance/add/{student}', [StudentController::class, 'add_circumstance'])->name('student.circumstance.add')->middleware('staff');
Route::any('/student/circumstance/update', [StudentController::class, 'update_circumstance'])->name('student.circumstance.update')->middleware('staff');
Route::delete('/student/circumstance/remove', [StudentController::class, 'remove_circumstance'])->name('student.circumstance.remove')->middleware('staff');
Route::any('/student/circumstances/{student}', [StudentController::class, 'student_circumstances'])->name('student.circumstances')->middleware('staff');
Route::any('/student/note/add/{student}', [StudentController::class, 'add_note'])->name('student.note.add')->middleware('staff');
Route::any('/student/note/update', [StudentController::class, 'update_note'])->name('student.note.update')->middleware('staff');
Route::any('/student/note/edit', [StudentController::class, 'edit_note'])->name('student.note.edit')->middleware('staff');
Route::any('/student/note/modify', [StudentController::class, 'modify_note'])->name('student.note.modify')->middleware('staff');
Route::delete('/student/note/remove', [StudentController::class, 'remove_note'])->name('student.note.remove')->middleware('staff');
Route::any('/student/notes/{student}', [StudentController::class, 'student_notes'])->name('student.notes')->middleware('staff');

Route::any('/assignment/upload_attendance', [CSVUploadController::class, 'attendance'])->name('file.upload.attendance')->middleware('staff');
Route::any('/assignment/upload_marks', [CSVUploadController::class, 'assignment_marks'])->name('file.upload.assignment')->middleware('staff');
Route::any('/assignment/upload_students', [CSVUploadController::class, 'upload_students'])->name('file.upload.students')->middleware('staff');
Route::any('/assignment/upload_student_accounts', [CSVUploadController::class, 'upload_student_accounts'])->name('file.upload.student_accounts')->middleware('admin');

Route::get('/pdf/class_records/{class_id}', [PDFController::class, 'class_records'])->name('pdf.class_records')->middleware('staff');
Route::get('/pdf/student_records/{student_id}', [PDFController::class, 'student_records'])->name('pdf.student_records')->middleware('staff');