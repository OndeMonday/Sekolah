<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\TransaksiController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherExport;
use App\Exports\StudentsExport;
use App\Exports\StudentsPerClassExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\MuridTelegramKontakController;
use App\Http\Controllers\TelegramWebhookController;
use App\Services\TelegramService;

    Route::post('/telegram/webhook', [TelegramWebhookController::class, 'handle']);



       Route::get('/test-telegram', function (TelegramService $telegram) {

    $chatId = "ISI_CHAT_ID_KAMU";

    return $telegram->sendMessage(
        $chatId,
        "Tes absensi: bot sudah jalan"
    );
});


Route::get('murid',[UserController::class,'murid']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('midtrans/callback',[TransaksiController::class, 'callback']);

Route::middleware(['auth:sanctum'])->group(function() {

    Route::get('info', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::middleware(['token.expired'])->group(function () {   
    Route::get('/profile', function (Request $request) {
    return $request->user();
    });
       Route::post('laporan',[LaporanController::class, 'addlaporan']);//tambah laporan
       Route::put('laporan/{id}',[LaporanController::class, 'editlaporan']);//update laporan
       Route::delete('laporan/{id}',[LaporanController::class, 'hapuslaporan']);//delete 
       Route::get('laporan',[LaporanController::class, 'lihatlaporan']);//hasil melaporkan orang
       Route::get('laporan/saya',[LaporanController::class,'pelanggaransaya']);//pelanggaran saya
       Route::get('pelanggaran',[PelanggaranController::class, 'lihatpelanggaran']);







Route::post('transaksi',[TransaksiController::class, 'store']);
Route::get('transaksi',[TransaksiController::class, 'index']);
Route::get('transaksi/{id}',[TransaksiController::class, 'show']);


    
    Route::get('/absen/me', [AbsensiController::class, 'myAbsensi']);

});

        Route::prefix('admin')->middleware(['role:admin'])->group(function() {
        Route::get('kelas', [ClassController::class, 'daftarkelas']);
        Route::post('kelas', [ClassController::class, 'buatkelas']);
        Route::delete('kelas/{name}', [ClassController::class, 'hapuskelas']);
        Route::put('kelas/{url}', [ClassController::class, 'gantinama']);

        Route::get('kelas/isi/{kelas}', [ClassController::class, 'isikelas']);
        Route::get('kelas/murid/{ClassId}', [UserController::class, 'studentsByClass']);
        Route::get('murid',[UserController::class,'murid']);//cek jumlah guru kelas murid
        

        Route::post('kelas/murid/{kelas}',[ClassController::class, 'assignStudents']);
        Route::delete('kelas/murid/{nisn}',[ClassController::class, 'removemurid']);
        Route::post('kelas/guru/{kelas}',[ClassController::class, 'assignTeachers']);
        Route::get('murid/all',[UserController::class,'muridall']);

        Route::post('{id}/reset',[UserController::class, 'resetpassword']);
        Route::put('{id}/role',[UserController::class, 'updateRole']);
        Route::post('register', [AuthController::class, 'register']);

        Route::post('pelanggaran',[PelanggaranController::class, 'addpelanggaran']);
        Route::put('pelanggaran/{id}',[PelanggaranController::class, 'editpelanggaran']);
        Route::delete('pelanggaran/{id}',[PelanggaranController::class, 'hapuspelanggaran']);
        Route::get('pelanggaran',[PelanggaranController::class, 'lihatpelanggaran']);
        Route::get('pelanggaran/{id}',[PelanggaranController::class, 'satupelanggaran']);

     Route::get('laporan/orang/{userid}',[LaporanController::class,'pelanggaranorang']);//lihat pelanggaran akun tersebut
       Route::get('laporan/per/{laporanid}',[LaporanController::class,'satulaporan']);//1 orang 1laporan
       Route::post('laporan/nilai/{laporanid}',[LaporanController::class,'nilailaporan']);//memberi nilai [status]
       Route::get('laporan/jenis/{pelanggaranid}',[LaporanController::class,'jenislaporan']);//lihat yang melanggar dalam pelanggaran tertentu
       Route::get('laporan/semua',[LaporanController::class,'laporansemua']);//semua laporan

       Route::get('/absen', [AbsensiController::class, 'index']);

        Route::apiResource('telegram-kontak', MuridTelegramKontakController::class);


        

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

Route::get(
    '/absen/pdf',
    [AbsensiController::class, 'exportPdf']
);
});



    Route::prefix('guru')->middleware(['role:guru'])->group(function() {
        Route::post('tasks/{name}', [TaskController::class, 'store']);
        Route::get('tasks', [TaskController::class, 'taskbyteacher']);   
        Route::put('tasks/{id}', [TaskController::class, 'updatetask']);
        Route::delete('tasks/{id}', [TaskController::class, 'deletetask']);      
        Route::get('tasks/{name}', [TaskController::class, 'taskbyclass']);  
        
        Route::post('approve/{id}', [SubmissionController::class, 'approved']);
        Route::put('approve/{id}', [SubmissionController::class, 'approvedd']);

        
        Route::get('submission/{id}', [SubmissionController::class, 'index']);

        Route::get('kelas/{name}', [UserController::class, 'TeacherStudentByClass']);
        Route::get('kelas', [ClassController::class, 'kelasajar']);

    });


    Route::prefix('murid')->middleware(['role:murid'])->group(function () {

    Route::get('tasks', [TaskController::class, 'tasksForStudent']);

    Route::get('submissions/all', [SubmissionController::class, 'getAll']);
    Route::get('submissions', [SubmissionController::class, 'ceksub']);
    Route::get('submissions/{TaskId}', [SubmissionController::class, 'taskbyid']);
    Route::post('submissions/{TaskId}', [SubmissionController::class, 'store']);
    Route::put('submissions/{TaskId}', [SubmissionController::class, 'update']);
    Route::delete('submissions/{TaskId}', [SubmissionController::class, 'hapussub']);

});

Route::prefix('kantin')->middleware('role:kantin')->group(function() {
Route::post('menu', [MenuController::class, 'store']);
Route::get('menu/{id}', [MenuController::class, 'show']);
Route::put('menu/{id}', [MenuController::class, 'update']);
Route::delete('menu/{id}', [MenuController::class, 'destroy']);
Route::post('menu/{menuid}', [MenuController::class, 'tambah']);


Route::post('detail-transaksi',[DetailTransaksiController::class, 'store']);//menambah item ke transaksi
Route::get('detail-transaksi',[DetailTransaksiController::class, 'index']);//mengambil semua detail transaksi
Route::get('detail-transaksi/{id}',[DetailTransaksiController::class, 'show']);//mengambil detail tertentu
Route::put('detail-transaksi/{id}',[DetailTransaksiController::class, 'update']);//update detail transaksi
Route::delete('detail-transaksi/{id}',[DetailTransaksiController::class, 'destroy']);//delete detail transaksi

});
Route::middleware(['auth:sanctum', 'absen.time'])
    ->post('/absen', [AbsensiController::class, 'store']);
});