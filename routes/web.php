<?php

use App\Http\Controllers\{
    AuthController,
    CommonController,
    GroupController,
    UserController
};
use Illuminate\Support\Facades\{Route};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->middleware(['auth', 'checkLogin']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/handleLogin', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/error', function () {
    return view('common.error');
})->middleware(['checkLogin', 'no-cache'])->name('error');

Route::prefix('common')->as('common.')->group(function () {
    Route::get('resetSearch', [CommonController::class, 'resetSearch'])->name('resetSearch');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'checkLogin','no-cache']], function () {

    Route::group(['prefix' => 'user'], function () {
        // user list search
        Route::get('/', [UserController::class, 'userList'])->name('userList');
        Route::post('/export',[UserController::class, 'exportCSV'])->middleware(['checkPermissions','check-director'])->name('userExport');
        Route::post('/clear',[UserController::class, 'clearSearch'])->name('clear');

        // add
        Route::get('/add-edit-delete', [UserController::class, 'add'])->middleware(['checkPermissions','check-director'])->name('add');
        Route::post('/add-edit-delete', [UserController::class, 'handleAdd'])->middleware(['checkPermissions','check-director'])->name('handleAdd');

        // edit delele
        Route::get('/add-edit-delete/{id}', [UserController::class, 'edit'])->middleware(['checkPermissions'])->name('edit');
        Route::put('/add-edit-delete/{id}', [UserController::class, 'handleEdit'])->middleware(['checkPermissions','check-director'])->name('handleEdit');
        Route::put('/updatePassword/{id}', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::get('/delete/{id}', [UserController::class, 'handleDelete'])->middleware(['checkPermissions'])->name('handleDelete');
        Route::get('/cancle', [UserController::class, 'cancle']);
        // route check email exist
        Route::get('/checkemail', [UserController::class, 'checkExistEmail'])->name('checkEmail');

    });

    Route::group(['prefix' => 'group', 'middleware' => ['check-director']], function () {
        Route::get('/', [GroupController::class, 'groupList'])->name('groupList');
        Route::post('/import', [GroupController::class, 'import'])->name('import');
    });
});
