<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//la ruta tiene un guard llamado isLogueado, que sirve para verificar tu token
Route::get('/events', [EventController::class, 'getAll'])->middleware('isLogeado');
Route::get('/events/{id}', [EventController::class, 'getById'])->middleware('isLogeado');
Route::get('/events/{id}/participants', [EventController::class, 'getParticipantsByEvent'])->middleware('isLogeado');
Route::delete('/events/{id}', [EventController::class, 'delete'])->middleware('isLogeado');
Route::post('/events/{event_id}/join/', [EventController::class, 'join'])->middleware('isLogeado');
Route::post('/events/{event_id}/leave/', [EventController::class, 'leave'])->middleware('isLogeado');
Route::get('/my-events', [EventController::class, 'getMyEvents'])->middleware('isLogeado');
Route::post('/event', [EventController::class, 'createEvent'])->middleware('isLogeado');
Route::put('/event/{id}', [EventController::class, 'editEvent'])->middleware('isLogeado');
?>
