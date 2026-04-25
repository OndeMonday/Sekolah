<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelanggaranController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherExport;
use App\Exports\StudentsExport;
use App\Exports\StudentsPerClassExport;
use Illuminate\Support\Facades\DB;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('info', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->middleware(['role:admin'])->group(function() {
        Route::get('kelas', [ClassController::class, 'daftarkelas']);
        Route::post('kelas', [ClassController::class, 'buatkelas']);
        Route::delete('kelas/{id}', [ClassController::class, 'hapuskelas']);
        Route::put('kelas/{name}', [ClassController::class, 'gantinama']);

        Route::get('kelas/isi/{kelas}', [ClassController::class, 'isikelas']);
        Route::get('kelas/murid/{id}', [UserController::class, 'studentsByClass']);
        

        Route::post('kelas/murid/{kelas}',[ClassController::class, 'assignStudents']);
        Route::post('kelas/guru/{kelas}',[ClassController::class, 'assignTeachers']);

        Route::post('{id}/reset',[UserController::class, 'resetpassword']);
        Route::put('{id}/role',[UserController::class, 'updateRole']);
        Route::post('register', [AuthController::class, 'register']);

        Route::post('pelanggaran', [PelanggaranController::class, 'tipepelanggaran']);
        Route::get('pelanggaran', [PelanggaranController::class, 'listpelanggaran']);
        Route::put('pelanggaran/{id}', [PelanggaranController::class, 'updatepelanggaran']);
        Route::delete('pelanggaran/{id}', [PelanggaranController::class, 'deletepelanggaran']);

       Route::get('/export/guru', function () {
    return Excel::download(new TeacherExport, 'teachers.xlsx');
});

Route::get('/export/murid/{name}', function ($name) {

    $class = DB::table('classes')->where('name',$name)->first();

    return Excel::download(
        new StudentsPerClassExport($class->name),
        'students-'.$class->name.'.xlsx'
    );
});
Route::get('/export/murid', function () {
    return Excel::download(
        new StudentsExport,
        'students.xlsx'
    );
});
});



    Route::prefix('guru')->middleware(['role:guru'])->group(function() {
        Route::post('tasks', [TaskController::class, 'store']);
        Route::get('tasks', [TaskController::class, 'taskbyteacher']);   
        Route::patch('tasks/{id}', [TaskController::class, 'updatetask']);
        Route::delete('tasks/{id}', [TaskController::class, 'deletetask']);      
        Route::get('tasks/{name}', [TaskController::class, 'taskbyclass']);  
        
        Route::post('approve/{id}', [SubmissionController::class, 'approved']);
        
        Route::get('submission/{id}', [SubmissionController::class, 'index']);
        
        Route::get('kelas/{name}', [UserController::class, 'TeacherStudentByClass']);

    });


    Route::prefix('murid')->middleware(['role:murid'])->group(function() {
        Route::get('tasks',[TaskController::class, 'tasksForStudent']);
        Route::post('submissions',[SubmissionController::class, 'store']);
        //Route::delete('murid/submissions/{id}',[SubmissionController::class, 'hapussub']);
        //Route::get('murid/submissions/{id}',[SubmissionController::class, 'ceksub']);
        Route::post('submissions/{id}',[SubmissionController::class, 'update']);

    });

    Route::middleware(['check.token'])->group(function() {
        Route::get('/profile', function($request) {
            return $request->user();
        });
    });
});
