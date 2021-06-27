<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LoginController;

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


Route::get('/', [LoginController::class, 'login_form']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DepartmentController::class, 'dashboard']);
Route::post('/confirm-password', [DepartmentController::class, 'confirm_password']);
Route::post('/set-semester', [DepartmentController::class, 'set_semester']);
Route::post('/set-school-year', [DepartmentController::class, 'set_school_year']);
Route::post('/students-list', [DepartmentController::class, 'students_list']);

Route::get('/profile', [DepartmentController::class, 'profile']);
Route::post('/profile/department-information', [DepartmentController::class, 'profile_update_dept']);
Route::post('/profile/account-information', [DepartmentController::class, 'profile_update_username']);
Route::post('/profile/change-password', [DepartmentController::class, 'profile_update_password']);

Route::get('/curriculum', [DepartmentController::class, 'curriculum']);
Route::get('/curriculum/option-pre-req/{ref}', [DepartmentController::class, 'option_pre_req']);
Route::post('/curriculum/edit-reference', [DepartmentController::class, 'edit_reference']);
Route::post('/curriculum/create-curriculum', [DepartmentController::class, 'create_curriculum']);
Route::post('/curriculum/edit-subject', [DepartmentController::class, 'edit_subject']);
Route::post('/curriculum/remove-subject', [DepartmentController::class, 'remove_subject']);



Route::get('/students', [DepartmentController::class, 'students']);
Route::post('/students/register-student', [DepartmentController::class, 'reg_student']);
Route::post('/students/bulk-registration', [DepartmentController::class, 'bulk_registration']);
Route::get('/students/student-record/{id}', [DepartmentController::class, 'student_record']);
Route::post('/students/student-new-curriculum', [DepartmentController::class, 'student_new_curr']);
Route::post('/students/update-student', [DepartmentController::class, 'update_student']);
Route::get('/students/student-record/evaluations/{id}', [DepartmentController::class, 'student_evaluation_records']);
Route::get('/students/{year}/{syf}-{syt}', [DepartmentController::class, 'students_list_view']);


Route::get('/evaluation', [DepartmentController::class, 'evaluation']);
Route::get('/evaluation/student-record/{id}', [DepartmentController::class, 'evaluation_record']);
Route::post('/evaluation/edit-year-level', [DepartmentController::class, 'edit_year_level']);
Route::post('/evaluation/edit-status', [DepartmentController::class, 'edit_status']);
Route::post('/evaluation/student-record/add-grade', [DepartmentController::class, 'add_grade']);
Route::post('/evaluation/student-record/update-grade', [DepartmentController::class, 'update_grade']);
Route::post('/evaluation/student-record/credit-grade', [DepartmentController::class, 'credit_grade']);
Route::post('/evaluation/student-record/pre-evaluate', [DepartmentController::class, 'pre_evaluate']);
Route::post('/evaluation/student-record/evaluate', [DepartmentController::class, 'evaluate_student']);
Route::get('/evaluation/student-evaluation/{id}/{evl}', [DepartmentController::class, 'evaluation_info']);

Route::get('/reports', [DepartmentController::class, 'reports']);
Route::get('/reports/evaluation/{id}/{evl}', [DepartmentController::class, 'reports_evaluation_info']);
Route::post('/reports/search', [DepartmentController::class, 'search']);

Route::get('/print/evaluation/{id}/{evl}', [DepartmentController::class, 'print']);
Route::get('/print/curriculum/{reference}', [DepartmentController::class, 'print_curr']);
Route::get('/print/record/{id}', [DepartmentController::class, 'print_record']);
Route::get('/print/student-record/{id}/{ref}', [DepartmentController::class, 'print_student_record']);


Route::get('/blank', [DepartmentController::class, 'blank']);


