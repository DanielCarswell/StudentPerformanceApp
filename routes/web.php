<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClassController;
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

Route::get('/homepage', function () {
    return view('index');
})->name('homepage');

Route::get('/', function () {
    return view('index');
});

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin')->middleware('staff');

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

Route::post('/admin/student/advisors/search_advisors', [AccountController::class, 'search_advisors'])->name('search_advisors')->middleware('admin');
Route::any('/admin/student/advisors/{student}', [AccountController::class, 'advisors'])->name('student.advisors')->middleware('admin'); 
Route::any('/admin/student/advisors/add/{student}', [AccountController::class, 'add_advisor'])->name('student.advisors.add')->middleware('admin'); 
Route::any('/admin/student/advisors/add/{student_id}/{advisor_id}', [AccountController::class, 'advisor_add'])->name('student.add_advisor')->middleware('admin'); 
Route::delete('/admin/student/advisors/delete/{student_id}/{advisor_id}', [AccountController::class, 'delete_advisor'])->name('student.delete_advisor')->middleware('admin'); 

Route::any('/graphs/barchart/class_grades/{class}', [ChartController::class, 'class_grades'])->name('graph.class_grades')->middleware('adminlecturer');
Route::any('/graphs/pichart/ratings/{class}', [ChartController::class, 'class_ratings'])->name('graph.class_ratings')->middleware('adminlecturer');
Route::any('/graphs/student_details/{student}', [ChartController::class, 'student_details'])->name('graph.student_details')->middleware('adminadvisor');
Route::any('/graphs/student_ratings/{student}', [ChartController::class, 'student_ratings'])->name('graph.student_ratings')->middleware('adminadvisor');
Route::any('/graphs/select', [ChartController::class, 'select_graph'])->name('graph');

Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('auth');
Route::get('/admin/classes', [ClassController::class, 'admin_index'])->name('admin_classes')->middleware('adminlecturer');
Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('create_class')->middleware('adminlecturer'); 
Route::post('/admin/create/class', [ClassController::class, 'create_class'])->name('class.create')->middleware('adminlecturer');
Route::any('/admin/class/edit/{class}', [ClassController::class, 'edit'])->name('class.edit')->middleware('adminlecturer'); 
Route::post('/admin/classes/modify', [ClassController::class, 'modify'])->name('class.modify')->middleware('adminlecturer'); 
Route::post('/admin/classes/delete/{class}', [ClassController::class, 'delete'])->name('delete_class')->middleware('adminlecturer'); 
Route::delete('/admin/classes/destroy/{class_id}', [ClassController::class, 'destroy'])->name('destroy_class')->middleware('adminlecturer'); 
Route::post('/admin/search_classes', [ClassController::class, 'search_classes'])->name('search_classes')->middleware('adminlecturer');
Route::post('/admin/class/students/search_students', [ClassController::class, 'search_class_students'])->name('search_class_students')->middleware('adminlecturer');
Route::post('/admin/class/lecturers/search_lecturers', [ClassController::class, 'search_class_lecturers'])->name('search_class_lecturers')->middleware('adminlecturer');
Route::any('/admin/class/students/{class}', [ClassController::class, 'students'])->name('class.students')->middleware('adminlecturer'); 
Route::any('/admin/class/lecturers/{class}', [ClassController::class, 'lecturers'])->name('class.lecturers')->middleware('adminlecturer'); 
Route::any('/admin/class/students/add/{class}', [ClassController::class, 'add'])->name('class.students.add')->middleware('adminlecturer'); 
Route::any('/admin/class/lecturers/add/{class}', [ClassController::class, 'add_lecturer'])->name('class.lecturers.add')->middleware('adminlecturer'); 
Route::any('/admin/class/students/add/{class_id}/{student_id}', [ClassController::class, 'add_student'])->name('class.add_student')->middleware('adminlecturer'); 
Route::any('/admin/class/lecturers/add/{class_id}/{lecturer_id}', [ClassController::class, 'lecturer_add'])->name('class.add_lecturer')->middleware('adminlecturer'); 
Route::delete('/admin/class/students/delete/{class_id}/{student_id}', [ClassController::class, 'delete_student'])->name('class.delete_student')->middleware('adminlecturer'); 
Route::delete('/admin/class/lecturers/delete/{class_id}/{lecturer_id}', [ClassController::class, 'delete_lecturer'])->name('class.delete_lecturer')->middleware('adminlecturer'); 
Route::post('/class/assignments/{class}', [ClassController::class, 'assignments'])->name('class.assignments')->middleware('adminlecturer');
Route::any('/admin/classes/assignment_grades/{assignment}/{class}', [ClassController::class, 'assignment_grades'])->name('assignment_grades')->middleware('adminlecturer'); 
Route::get('/class/upload_students', [ClassController::class, 'upload_students'])->name('upload_students')->middleware('adminlecturer');
Route::any('/classes/class_records/{class}', [ClassController::class, 'class_records'])->name('classes.class_records')->middleware('adminlecturer');
Route::post('/classes/student_records/{student}', [ClassController::class, 'student_records'])->name('classes.student_records')->middleware('staff');
Route::get('/classes/upload_attendance', [ClassController::class, 'upload_attendance'])->name('upload_attendance')->middleware('adminlecturer');
Route::post('/classes/update_attendance', [ClassController::class, 'update_attendance'])->name('update_attendance')->middleware('adminlecturer');
Route::any('/classes/attendance/{class}', [ClassController::class, 'class_attendance'])->name('class_attendance')->middleware('adminlecturer'); 


Route::any('/admin/assignments/add_assignment/{class_id}', [AssignmentController::class, 'create'])->name('create_assignment')->middleware('adminlecturer');
Route::post('/admin/assignments/add_assignment', [AssignmentController::class, 'add'])->name('add_assignment')->middleware('adminlecturer');
Route::any('/admin/assignments/edit/{assignment_id}/{class_id}', [AssignmentController::class, 'edit'])->name('edit_assignment')->middleware('adminlecturer');
Route::post('/admin/assignments/edit', [AssignmentController::class, 'modify'])->name('modify_assignment')->middleware('adminlecturer');
Route::any('/admin/assignments/index/{class_id}', [AssignmentController::class, 'class_assignments'])->name('class_assignments')->middleware('adminlecturer');
Route::post('/admin/search_assignments', [AssignmentController::class, 'search_assignments'])->name('search_assignments')->middleware('adminlecturer');
Route::post('/admin/assignments/delete/{class_id}/{assignment_id}', [AssignmentController::class, 'delete'])->name('delete_assignment')->middleware('adminlecturer');
Route::delete('/admin/assignments/destroy/{assignment_id}/{class_id}', [AssignmentController::class, 'destroy'])->name('destroy_assignment')->middleware('adminlecturer');
Route::get('/assignments/upload_marks', [AssignmentController::class, 'upload'])->name('upload_assignment_marks')->middleware('adminlecturer');
Route::post('/admin/assignments/update_mark', [AssignmentController::class, 'update_mark'])->name('update_assignment_mark')->middleware('adminlecturer');

Route::any('/admin/user/roles/index/{user_id}', [RoleController::class, 'user_roles'])->name('user_roles')->middleware('admin');
Route::get('/admin/user/roles/add/{user}', [RoleController::class, 'give'])->name('give_role')->middleware('admin');
Route::post('/admin/user/roles/add', [RoleController::class, 'give_role'])->name('give_user_role')->middleware('admin');
Route::post('/admin/user/remove_role', [RoleController::class, 'remove'])->name('remove_role')->middleware('admin'); 

Route::any('/admin/circumstances', [CircumstanceController::class, 'index'])->name('circumstances')->middleware('adminadvisor');
Route::any('/admin/circumstances/{circumstance}/links', [CircumstanceController::class, 'links'])->name('circumstance.links')->middleware('adminadvisor');
Route::delete('/admin/circumstances/links/destroy', [CircumstanceController::class, 'delete_link'])->name('circumstance.links.delete')->middleware('adminadvisor');
Route::post('/admin/circumstances/add_link', [CircumstanceController::class, 'add_link'])->name('circumstance.add_link')->middleware('adminadvisor');
Route::get('/admin/circumstances/add', [CircumstanceController::class, 'add'])->name('circumstance.add')->middleware('adminadvisor');
Route::post('/admin/circumstances/create', [CircumstanceController::class, 'create'])->name('circumstance.create')->middleware('adminadvisor');
Route::any('/admin/circumstances/edit/{circumstance}', [CircumstanceController::class, 'edit'])->name('circumstance.edit')->middleware('adminadvisor');
Route::post('/admin/circumstances/update', [CircumstanceController::class, 'update'])->name('circumstance.update')->middleware('adminadvisor');
Route::post('/admin/circumstances/delete/{circumstance}', [CircumstanceController::class, 'delete'])->name('circumstance.delete')->middleware('adminadvisor');
Route::delete('/admin/circumstances/destroy/{circumstance}', [CircumstanceController::class, 'destroy'])->name('circumstance.destroy')->middleware('adminadvisor');

Route::any('/students', [StudentController::class, 'index'])->name('students')->middleware('adminadvisor');
Route::any('/student/circumstance/add/{student}', [StudentController::class, 'add_circumstance'])->name('student.circumstance.add')->middleware('adminadvisor');
Route::any('/student/circumstance/update', [StudentController::class, 'update_circumstance'])->name('student.circumstance.update')->middleware('adminadvisor');
Route::delete('/student/circumstance/remove', [StudentController::class, 'remove_circumstance'])->name('student.circumstance.remove')->middleware('adminadvisor');
Route::any('/student/circumstances/{student}', [StudentController::class, 'student_circumstances'])->name('student.circumstances')->middleware('adminadvisor');
Route::any('/student/note/add/{student}', [StudentController::class, 'add_note'])->name('student.note.add')->middleware('adminadvisor');
Route::any('/student/note/update', [StudentController::class, 'update_note'])->name('student.note.update')->middleware('adminadvisor');
Route::any('/student/note/edit/{student_id}/{topic}/{note}', [StudentController::class, 'edit_note'])->name('student.note.edit')->middleware('adminadvisor');
Route::any('/student/note/modify', [StudentController::class, 'modify_note'])->name('student.note.modify')->middleware('adminadvisor');
Route::delete('/student/note/remove', [StudentController::class, 'remove_note'])->name('student.note.remove')->middleware('adminadvisor');
Route::any('/student/notes/{student}', [StudentController::class, 'student_notes'])->name('student.notes')->middleware('adminadvisor');

Route::any('/assignment/upload_attendance', [CSVUploadController::class, 'attendance'])->name('file.upload.attendance')->middleware('adminlecturer');
Route::any('/assignment/upload_marks', [CSVUploadController::class, 'assignment_marks'])->name('file.upload.assignment')->middleware('adminlecturer');
Route::any('/assignment/upload_students', [CSVUploadController::class, 'upload_students'])->name('file.upload.students')->middleware('adminlecturer');
Route::any('/assignment/upload_student_accounts', [CSVUploadController::class, 'upload_student_accounts'])->name('file.upload.student_accounts')->middleware('admin');

Route::get('/pdf/class_records/{class_id}', [PDFController::class, 'class_records'])->name('pdf.class_records')->middleware('adminlecturer');
Route::get('/pdf/student_records/{student_id}', [PDFController::class, 'student_records'])->name('pdf.student_records')->middleware('adminadvisor');