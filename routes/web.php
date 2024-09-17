<?php

use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TopicController;
use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\Submission;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('home')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}/classroom/{classroom}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/plans', [PlansController::class, 'index'])->name('plans');

Route::middleware('auth')->group(function () {

    Route::post('/subscription', [SubscriptionsController::class, 'store'])->name('subscriptions.store');


    Route::get('/subscriptions/{subscription}/pay', [PaymentsController::class, 'create'])->name('chackout');
    Route::post('/payments/{subscription}', [PaymentsController::class, 'store'])->name('payments.store');
    Route::get('/payments/{subscription}/success', [PaymentsController::class, 'success'])->name('payments.success');
    Route::get('/payments/{subscription}/cancel', [PaymentsController::class, 'cancel'])->name('payments.cancel');


    Route::get('/classrooms/trached', [ClassroomsController::class, 'trached'])
        ->name('classrooms.trached');

    Route::put('/classrooms/trached/{classroom}', [ClassroomsController::class, 'restore'])
        ->name('classrooms.restore');

    Route::delete('/classrooms/trached/{classroom}', [ClassroomsController::class, 'forceDelete'])
        ->name('classrooms.force-delete');


    Route::get('/classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])->name('classrooms.join');
    Route::post('/classrooms/{classroom}/join', [JoinClassroomController::class, 'store']);

    Route::get('classrooms/{classroom}/chat',[ClassroomsController::class,'chat'])->name('classrooms.chat');

    Route::resource('/classrooms', ClassroomsController::class);
    Route::resource('/classrooms.classworks', ClassworkController::class);

    Route::resource('/classrooms.topics', TopicController::class);

    Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])
        ->name('classrooms.people');
    Route::delete('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])
        ->name('classrooms.people.destroy');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.delete');

    Route::get('/classworks/{classwork}/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/classworks/{classwork}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::put('/classworks/{classwork}/submissions', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])->name('submissions.file');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
});






// Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
// Route::post('/login', [LoginController::class, 'store'])->name('login.store')->middleware('guest');
