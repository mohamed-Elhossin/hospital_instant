<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CallController;
use App\Http\Controllers\API\V1\CaseController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\ReportController;
use App\Http\Controllers\API\V1\ConstantController;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\API\V1\CallMangerController;
use App\Http\Controllers\API\V1\MeasurementController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\MedicalRecordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::get('test', function () {
        return 'wer';
    });
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('show-profile', [AuthController::class, 'show']);

        Route::apiResource('case', CaseController::class);
        Route::post('make-request', [CaseController::class, 'makeRequest']);
        Route::post('add-nurse', [CaseController::class, 'addNurse']);

        Route::apiResource('calls', CallController::class);
        Route::put('calls-accept/{id}', [CallController::class, 'accept']);

        Route::apiResource('reports', ReportController::class);
        Route::apiResource('tasks', TaskController::class);
        Route::get('doctors', [ConstantController::class, 'doctors']);
        Route::post('attendance', [AttendanceController::class, 'store']);
        Route::post('measurement', [MeasurementController::class, 'store']);
        Route::get('measurement/{id}', [MeasurementController::class, 'show']);
        Route::apiResource('calls-manger', CallMangerController::class);
        Route::apiResource('medical-record', MedicalRecordController::class);
        Route::post('medical-record-show', [MedicalRecordController::class,'medicalRecordShow']);


        Route::Post('send-notification', [NotificationController::class, 'send']);
    });
});
