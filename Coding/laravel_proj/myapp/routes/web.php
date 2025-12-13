<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

Route::get('/', function (Illuminate\Http\Request $request) {
    $moduleName = $request->query('module', 'dashboard');
    $pageName = $request->query('page', 'home');
    $viewPath = "modules.{$moduleName}.{$pageName}";
    if (view()->exists($viewPath)) {
        return view($viewPath);
        
    }
    
    return redirect('/?module=dashboard&page=home')->with('error', 'Page not found.');
})->middleware('auth');

Auth::routes(['register' => false]);

Route::prefix('admin')->group(function () {
    
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'createUser'])->name('admin.createUser');
    Route::post('/users/{id}/toggle', [AdminController::class, 'toggleActive'])->name('admin.toggleActive');

    Route::get('/modules', [AdminController::class, 'modules'])->name('admin.modules');
    
    Route::post('/modules', [AdminController::class, 'createModule'])->name('admin.createModule');
    Route::post('/modules/{moduleId}/pages', [AdminController::class, 'createPage'])->name('admin.createPage');

    Route::get('/permissions/{userId}', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::post('/permissions/{userId}', [AdminController::class, 'assignPermission'])->name('admin.assignPermission');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
