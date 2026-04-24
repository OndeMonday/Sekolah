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

    Route::middleware(['role:admin'])->group(function() {
        Route::get('admin/kelas', [ClassController::class, 'daftarkelas']);
        Route::post('admin/kelas', [ClassController::class, 'buatkelas']);
        Route::delete('admin/kelas/{id}', [ClassController::class, 'hapuskelas']);
        Route::put('admin/kelas/{name}', [ClassController::class, 'gantinama']);

        Route::get('kelas/isi/{className}', [ClassController::class, 'isikelas']);
        Route::get('admin/kelas/{id}/murid', [UserController::class, 'studentsByClass']);
        

        Route::post('admin/kelas/{kelas}/students',[ClassController::class, 'assignStudents']);
        Route::post('admin/kelas/{kelas}/teachers',[ClassController::class, 'assignTeachers']);

        Route::post('admin/{nisn_nip}/reset',[UserController::class, 'resetpassword']);
        Route::put('admin/{nisn_nip}/role',[UserController::class, 'updateRole']);
        Route::post('admin/register', [AuthController::class, 'register']);

        Route::post('admin/pelanggaran', [PelanggaranController::class, 'tipepelanggaran']);
        Route::get('admin/pelanggaran', [PelanggaranController::class, 'listpelanggaran']);
        Route::put('admin/pelanggaran/{id}', [PelanggaranController::class, 'updatepelanggaran']);
        Route::delete('admin/pelanggaran/{id}', [PelanggaranController::class, 'deletepelanggaran']);

  



       Route::get('/export/teachers', function () {
    return Excel::download(new TeacherExport, 'teachers.xlsx');
});

Route::get('/export/students/{className}', function ($className) {

    $class = DB::table('classes')->where('name',$className)->first();

    return Excel::download(
        new StudentsPerClassExport($class->name),
        'students-'.$class->name.'.xlsx'
    );
});

Route::get('/export/students', function () {
    return Excel::download(
        new StudentsExport,
        'students.xlsx'
    );
});
});



    Route::middleware(['role:guru'])->group(function() {
        Route::post('guru/tasks', [TaskController::class, 'store']);
        Route::get('/guru/tasks', [TaskController::class, 'taskbyteacher']);   
        //Route::put('/guru/tasks/{id}', [TaskController::class, 'updatetask']);
        Route::delete('/guru/tasks/{id}', [TaskController::class, 'deletetask']);      
        Route::get('/guru/tasks/{ClassName}', [TaskController::class, 'taskbyclass']);  
        
        Route::post('/guru/approve/{id}', [SubmissionController::class, 'approved']);
        
        Route::get('guru/submission/{taskId}', [SubmissionController::class, 'index']);
        
        Route::get('guru/kelas/{id}', [UserController::class, 'TeacherStudentByClass']);

    });


    Route::middleware(['role:murid'])->group(function() {
        Route::get('murid/tasks',[TaskController::class, 'tasksForStudent']);
        Route::post('murid/submissions',[SubmissionController::class, 'store']);
        //Route::delete('murid/submissions/{id}',[SubmissionController::class, 'hapussub']);
        //Route::get('murid/submissions/{id}',[SubmissionController::class, 'ceksub']);
        Route::post('murid/submissions/{id}',[SubmissionController::class, 'update']);

    });

    Route::middleware(['check.token'])->group(function() {
        Route::get('/profile', function($request) {
            return $request->user();
        });
    });
});
