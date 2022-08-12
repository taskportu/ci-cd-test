<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/details',[UserController::class,'getDetails']);
Route::get('/reset-password',[UserController::class,'resetPassword']);
Route::post('/email-check-for-reset-password', [UserController::class, 'checkEmailForPasswordReset']);
Route::get('/token-verify-form', [UserController::class, 'tokenVerifyForm']);
Route::post('/token-verify-process', [UserController::class, 'tokenVerifyProcess']);
Route::get('/new-password-add-form', [UserController::class, 'newPasswordAddForm']);
Route::post('/new-password-add-process', [UserController::class, 'newPasswordAddProcess']);

// auth
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('layout.home');
});

Route::group(['middleware' => ['auth']], function() {

    //Department 
    Route::get('/departmentshowall', [DepartmentController::class, 'department_showall']); 
    Route::get('/departmentadd', [DepartmentController::class, 'department_add'])->name('department.add');
    Route::post('/departmentaddprocess', [DepartmentController::class, 'department_add_process']);
    Route::get('/departmentedit/{id}', [DepartmentController::class, 'department_edit']);
    Route::post('/departmentupdateprocess', [DepartmentController::class, 'departmentUpdateProcess']);
    Route::get('/departmentdelete/{id}', [DepartmentController::class, 'department_delete']);

    //Role
    Route::get('/role-show-all',[RoleController::class,'roleShowAll']);
    Route::get('/role-add', [RoleController::class, 'roleAdd']);
    Route::post('/role-add-process',[RoleController::class,'roleAddProcess']);
    Route::get('/role-edit/{id}',[RoleController::class,'roleEdit']);
    Route::post('/role-update-process',[RoleController::class,'roleUpdateProcess']);

    // course
    Route::get('/course-show-all',[CoursesController::class,'courseShowAll']);
    Route::get('/course-add',[CoursesController::class,'courseAdd']);
    Route::post('/course-add-process',[CoursesController::class,'courseAddProcess']);
    Route::get('/course-edit/{id}',[CoursesController::class,'courseEdit']);
    Route::post('/course-update-process',[CoursesController::class,'courseUpdateProcess']);

    // subject
    Route::get('/subject-show-all',[SubjectController::class,'subjectShowAll']);
    Route::get('/subject-add',[SubjectController::class,'subjectAdd']);
    Route::post('/subject-add-process',[SubjectController::class,'subjectAddProcess']);
    Route::get('/subject-edit/{id}',[SubjectController::class,'subjectEdit']);
    Route::post('/subject-update-process',[SubjectController::class,'subjectUpdateProcess']);

    // employee
    Route::get('/employee-add',[EmployeeController::class,'employeeAdd']);
    Route::post('/employee-add-process',[EmployeeController::class,'employeeAddProcess']);
    Route::get('/employee-show-all',[EmployeeController::class,'employeeShowAll']);
    Route::get('/employee-edit/{id}',[EmployeeController::class,'employeeEdit']);
    Route::post('/employee-update-process',[EmployeeController::class,'employeeUpdateProcess']);

    // student
    Route::get('/student-add',[StudentController::class,'studentAdd']);
    Route::post('/student-add-process',[StudentController::class,'studentAddProcess']);
    Route::get('/student-show-all',[StudentController::class,'studentShowAll']);
    Route::get('/student-edit/{id}',[StudentController::class,'studentEdit']);
    Route::post('/student-update-process',[StudentController::class,'studentUpdateProcess']);

    // user
    Route::get('/employee-user-add',[UserController::class,'employeeUserAdd']);
    Route::post('/employee-user-add-proccess',[UserController::class,'employeeUserAddProccess']);
    Route::get('/employee-user-show-all',[UserController::class,'employeeUserShowAll']);
    Route::get('/employee-user-delete/{id}', [UserController::class, 'employeeUserDelete']);
    Route::post('/employee-user-password-edit', [UserController::class, 'editPassword']); 
    Route::get('/logout',[UserController::class,'logOut']);
 });





