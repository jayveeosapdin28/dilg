<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\V1\Document\DocumentController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\V1\Task\TaskController;
use App\Http\Controllers\V1\Case\CaseController;
use App\Http\Controllers\V1\Rank\RankController;
use App\Http\Controllers\V1\Event\EventController;
use App\Http\Controllers\V1\User\UserController;
use App\Http\Controllers\V1\Chat\ChatController;
use App\Http\Controllers\V1\Notification\NotificationController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function (){
        Route::post('task/submit',[TaskController::class,"submitDocument"])->name('task.submit');
        Route::resources([
            'documents' => DocumentController::class,
            'tasks' => TaskController::class,
            'cases' => CaseController::class,
            'ranks' => RankController::class,
            'events' => EventController::class,
            'users' => UserController::class,
            'chats' => ChatController::class,
            'notifications' => NotificationController::class,
            'chat-rooms' => \App\Http\Controllers\V1\Chat\ChatRoomController::class,
        ]);
    });
});

Route::post('/upload-file',[FileController::class,'store']);

require __DIR__.'/auth.php';
