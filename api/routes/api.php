<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'tasks'
], function (){
    Route::get('/get_task_list', [TaskController::class, 'getTaskList']);
    Route::Post('/create_task', [TaskController::class, 'createTask']);
    Route::post('/complete_task', [TaskController::class, 'completeTask']);
});
