<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LocationServiceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\VenueImageController;
use App\Http\Controllers\VenuePaymentController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\CourtSlotController;
use App\Http\Controllers\BookingCourtController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/verifyEmail', [AuthController::class, 'verifyEmail']);

// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [UserController::class, 'me']);
});

// SportType routes

Route::get("/sportTypes", [SportTypeController::class, 'index']);
Route::get("/sportTypes/{id}", [SportTypeController::class, 'findById']);
Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::post('/sportTypes', [SportTypeController::class, 'store']);
    Route::put('/sportTypes/{id}', [SportTypeController::class, 'update']);
    Route::delete('/sportTypes/{id}', [SportTypeController::class, 'delete']);
});

// LocationService routes
Route::prefix('locationServices')->group(function () {
    Route::get('/getByVenueId/{id}', [LocationServiceController::class, 'index']);
    Route::get('/{id}', [LocationServiceController::class, 'findById']);
    Route::middleware(['auth:sanctum', 'ability:owner'])->group(function () {
        Route::post('/', [LocationServiceController::class, 'store']);
        Route::put('/{id}', [LocationServiceController::class, 'update']);
        Route::delete('/{id}', [LocationServiceController::class, 'delete']);
    });
});

// Review routes
Route::prefix('reviews')->group(function () {
    Route::get('/getByVenueId/{id}', [ReviewController::class, 'index']);
    Route::get('/{id}', [ReviewController::class, 'findById']);
    Route::middleware(['auth:sanctum', 'ability:user,admin'])->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::delete('/{id}', [ReviewController::class, 'delete']);
    });
});

// Field routes
Route::prefix('fields')->group(function () {
    Route::get('/getByVenueId/{id}', [FieldController::class, 'index']);
    Route::get('/{id}', [FieldController::class, 'findById']);
    Route::middleware(['auth:sanctum', 'ability:owner'])->group(function () {
        Route::post('/', [FieldController::class, 'store']);
        Route::put('/{id}', [FieldController::class, 'update']);
        Route::delete('/{id}', [FieldController::class, 'delete']);
    });
});

// Venue routes
Route::prefix('venues')->group(function () {
    Route::get('/', [VenueController::class, 'index']);
    Route::get('/search_by_id/{venue_id}', [VenueController::class, 'findById']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [VenueController::class, 'store']);
        Route::put('/{venue_id}', [VenueController::class, 'update']);
        Route::delete('/{venue_id}', [VenueController::class, 'delete']);
        Route::patch('/{venue_id}/status', [VenueController::class, 'updateStatus']);

    });
});

// VenueImage routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/venue-images/{venue_id}', [VenueImageController::class, 'getImagesByVenue']);
    Route::post('/venue-images/{venue_id}', [VenueImageController::class, 'store']);
    Route::delete('/venue-images/{image_id}', [VenueImageController::class, 'destroy']);
    Route::put('/venue-images/{image_id}/thumbnail', [VenueImageController::class, 'updateThumbnail']);
});

// Payment routes
Route::get('/paymentReminderEmail', [VenuePaymentController::class, 'paymentReminderEmail']);
Route::get('/unpaidVenueLocking', [VenuePaymentController::class, 'unpaidVenueLocking']);
Route::post('/webhook/handlePayment', [VenuePaymentController::class, 'handle']);
Route::middleware(['auth:sanctum', 'ability:owner'])->group(function () {
    Route::post('/venuePayment/{venue_id}', [VenuePaymentController::class, 'make']);
    Route::get('/venuePayment', [VenuePaymentController::class, 'getAllVenueByOwnerId']);
});

//Court routes
Route::prefix('court')->group(function () {
    Route::get('/', [CourtController::class, 'index']);
    Route::post('/', [CourtController::class, 'store']);
    Route::get('/{id}', [CourtController::class, 'findById']);
    Route::put('/{id}', [CourtController::class, 'update']);
    Route::delete('/{id}', [CourtController::class, 'delete']);
});

Route::prefix('courtslot')->group(function () {
    Route::get('/', [CourtSlotController::class, 'index']);
    Route::post('/', [CourtSlotController::class, 'store']);
    Route::get('/{id}', [CourtSlotController::class, 'findById']);
    Route::put('/{id}', [CourtSlotController::class, 'update']);
    Route::delete('/{id}', [CourtSlotController::class, 'delete']);
});
Route::prefix('bookingcourt')->group(function () {
    Route::get('/', [BookingCourtController::class, 'index']);
    Route::post('/', [BookingCourtController::class, 'store']);
    Route::get('/{id}', [BookingCourtController::class, 'findById']);
    Route::put('/{id}', [BookingCourtController::class, 'update']);
    Route::delete('/{id}', [BookingCourtController::class, 'delete']);
});
