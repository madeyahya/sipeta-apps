<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceExportController;
use App\Http\Controllers\Admin\ServiceStatusController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ServiceController as UserServiceController;
use App\Models\Service;
use App\Models\ServiceStatus;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;


Route::get('/storage/{path}', function (string $path) {
    $full = storage_path('app/public/'.$path);
    abort_unless(\Illuminate\Support\Facades\File::exists($full), 404);
    return response()->file($full);
})->where('path', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/service', [UserServiceController::class, 'index'])->name('service.index');
    Route::get('/service/{code}', [UserServiceController::class, 'show'])->name('service.show');

    Route::get('/take-service', [UserServiceController::class, 'take'])->name('service.take');
    Route::get('/preview', [UserServiceController::class, 'preview'])->name('service.preview');
    Route::get('/create-service', [UserServiceController::class, 'create'])->name('service.create');
    Route::post('/create-service', [UserServiceController::class, 'store'])->name('service.store');
    Route::get('/service-success', [UserServiceController::class, 'success'])->name('service.success');

    Route::get('/my-service', [UserServiceController::class, 'myService'])->name('service.myservice');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
ROute::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/service/export/pdf', [ServiceExportController::class, 'exportPdf'])
        ->name('service.export.pdf');

    Route::resource('/resident', ResidentController::class);
    Route::resource('/service', ServiceController::class);
    Route::resource('/service-category', ServiceCategoryController::class);

    Route::get('/service-status/{serviceId}/create', [ServiceStatusController::class, 'create'])->name('service-status.create');
    Route::resource('/service-status', ServiceStatusController::class)->except('create');
});
