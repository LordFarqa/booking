<?php
use App\Http\Controllers\Room\RoomController;
use App\Http\Controllers\UsersController;

use App\Http\Controllers\Hotel\HotelsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//admin

    //user
Route::prefix('admin')->group(function () {
    Route::get('/users', [UsersController::class, 'show']);
    Route::get('/user/{login}', [UsersController::class, 'showUserByLogin']);

    Route::post('/user/create', [UsersController::class,'createUser']);
    Route::put('/user/update/{id}', [UsersController::class,'updateUser']);
    Route::delete('/user/delete/{id}', [UsersController::class,'deleteUser']);
});

    //hotel
Route::get('/admin/hotels/', [HotelsController::class, 'show']);
    Route::get('/admin/hotel/{id}', [HotelsController::class, 'showHotelById']);   
    Route::post('/admin/hotel/create',[HotelsController::class,'createHotel']);
    Route::put('/admin/hotel/update/{id}',[HotelsController::class,'updateHotel']);
    Route::delete('/admin/hotel/delete/{id}',[HotelsController::class,'deleteHotel']);

    //rooms
    Route::get('/admin/hotel/{id}/rooms', [HotelsController::class, 'showRooms']);
    Route::post('/admin/hotel/{id}/create/room', [RoomController::class, 'createRoom']);
    Route::put('/admin/hotel/room/update/{id}', [RoomController::class, 'updateRoom']);
    Route::delete('/admin/hotel/room/delete/{id}', [RoomController::class, 'deleteRoom']);